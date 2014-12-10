-module(twitterminer_riak).

-export([twitter_example/2, twitter_save_pipeline/5, get_riak_hostport/1


	, initiate_bucket_purge/0, print/1, gather_tweets/0]). %gather:tweet

-record(hostport, {host, port}). 
-record(account_keys, {api_key, api_secret,
                       access_token, access_token_secret}).

% This file contains example code that connects to Twitter and saves tweets to Riak.
% It would benefit from refactoring it together with twitterminer_source.erl.

keyfind(Key, L) ->
  {Key, V} = lists:keyfind(Key, 1, L), 	
  V.

%% @doc Get Twitter account keys from a configuration file.
get_riak_hostport(Name) ->
  {ok, Nodes} = application:get_env(twitterminer, riak_nodes),
  {Name, Keys} = lists:keyfind(Name, 1, Nodes),
  #hostport{host=keyfind(host, Keys),
            port=keyfind(port, Keys)}.

%% @doc This example will download a sample of tweets and print it.
twitter_example(Category, Track) ->
  URL = "https://stream.twitter.com/1.1/statuses/filter.json",

  % We get our keys from the twitterminer.config configuration file.
  Keys = twitterminer_source:get_account_keys(account1),

  RHP = get_riak_hostport(riak1),
  {ok, Pid} = riakc_pb_socket:start_link(RHP#hostport.host, RHP#hostport.port),

  % Run our pipeline
  P = twitterminer_pipeline:build_link(twitter_save_pipeline(Pid, URL, Keys, Category, Track)),   %Track

  % If the pipeline does not terminate after 60 s, this process will
  % force it.
  T = spawn_link(fun () ->
        receive
          cancel -> ok
        after 60000 -> % Sleep fo 60 s
            twitterminer_pipeline:terminate(P)
        end
    end),

  Res = twitterminer_pipeline:join(P),
  T ! cancel,
  Res.



gather_tweets() ->  
Trackers = [{track, world}, {track, politics}, {track, business}, {track, technology}, {track, science}, {track, health}, {track, sports}],
[twitter_example(Y, {X, Y}) || {X, Y} <- Trackers].


%% @doc Create a pipeline that connects to twitter and
%% saves tweets to Riak. We save all messages that have ids,
%% which might include delete notifications etc.
twitter_save_pipeline(Pid, URL, Keys, Category, Track) ->


  Prod = twitterminer_source:twitter_producer(URL, Keys, Track),

  % Pipelines are constructed 'backwards' - consumer is first, producer is last.
  [
    twitterminer_pipeline:consumer(
      fun(Msg, N) -> save_tweet({Category, Pid}, Msg), N+1 end, 0),
    twitterminer_pipeline:map(
      fun twitterminer_source:decorate_with_id/1),
    twitterminer_source:split_transformer(),
    Prod].

% We save only objects that have ids.
save_tweet({Category, Pid}, {parsed_tweet, _L, Body, {id, Id}}) ->
  Obj = riakc_obj:new(binary(Category), list_to_binary(integer_to_list(Id)), Body), io:format("Tweet saved with ID: ~p~n", [Id]),
  riakc_pb_socket:put(Pid, Obj, [{w, 0}]);
save_tweet(_, _) -> io:format("save_tweet did not match: ~n", []).









  

binary(Category) ->
list_to_binary(atom_to_list(Category)).


check_id(C, Id) ->
    {C, Id}.

sort_list( Category_list, Id_list)->

    Zip = lists:zip(Category_list, Id_list),
    Res = lists:map(fun({C, Ids}) -> [check_id( C, Id) || Id <- Ids] end, Zip),
    lists:flatten(Res).




initiate_bucket_purge() ->

RHP = get_riak_hostport(riak1),
  {ok, Pid} = riakc_pb_socket:start_link(RHP#hostport.host, RHP#hostport.port),

Category_buckets = [world, politics, business, technology, science, health, sports],
%Category_buckets = [{account1, world}, {account1, politics}, {account1, business}, {account1, technology}, {account1, science}, {account1, health, {account1, sports}],
Binary_List = [binary(X) || X <- Category_buckets], 

Key_list = [riakc_pb_socket:list_keys(Pid, X) || X <- Binary_List], Filtered = [element(2, X) || X <- Key_list],

% %lists:foreach(fun(X) -> io:format("~p has been deleted from World.~n",[X]), delete_all_in_bucket(Pid, world, X) end, element(2, riakc_pb_socket:list_keys(Pid, binary(world)))).


%update_tweet(Pid, world, 540502044717903873), update_tweet(Pid, politics,540503773169213440), update_tweet(Pid, business, 540520288442535937), 
%	update_tweet(Pid, technology, 540512667946213378), update_tweet(Pid, science, 540520739326005248), update_tweet(Pid, health, 540520984692809728), update_tweet(Pid, sports, 540521258786373635).


%update_tweet(Pid, world, 540502156487315457),update_tweet(Pid, world, 540502378848727041),
%update_tweet(Pid, world, 540502321474437120),update_tweet(Pid, world, 540517732387545088),
%update_tweet(Pid, world, 540519739747860480),update_tweet(Pid, world, 540502505033977856),
%update_tweet(Pid, world, 540501878992560128),update_tweet(Pid, world, 540519751785517056),
%update_tweet(Pid, world, 540517840013369345),update_tweet(Pid, world, 540502008651063296),
%update_tweet(Pid, world, 540502009909350400),update_tweet(Pid, world, 540502412134731776).

%
%
%lists:foldl(
 %   fun (Category, [Ids | Id_listTail]) -> 
  %      lists:foreach(
   %         fun (Id) -> 
    %            update_tweet(Pid, Category, Id) 
     %       end, Ids),
      %  Id_listTail
    %end, Filtered, Category_buckets).





 Tuples = sort_list( Category_buckets, Filtered),

 [update_tweet(Pid, {C, list_to_integer(binary_to_list(T))}) || {C, T} <- Tuples].


%concurrency() ->
%spawn(twitterminer_riak, update_tweet(), )


%update_tweet(Pid, {business, 540520239671164930}),
%update_tweet(Pid, {business, 540520153897648129}). 

%[update_tweet(Pid, X) || X <- sort_list(Category_buckets, Key_list)].

%[update_tweet(Pid, {business, X}) || X <- Test].


print(Key) ->

 URL = "https://api.twitter.com/1.1/statuses/show.json", 	

  Keys = twitterminer_source:get_account_keys(account1),


  Consumer = {Keys#account_keys.api_key, Keys#account_keys.api_secret, hmac_sha1},
  AccessToken = Keys#account_keys.access_token,
  AccessTokenSecret = Keys#account_keys.access_token_secret,


  SignedParams = oauth:sign("GET", URL, [{id, Key}], Consumer, AccessToken, AccessTokenSecret), io:format("This is it: ~p", [oauth:uri(URL, SignedParams)]).


 update_tweet(Pid, {Category, Bucket_key}) ->  


  URL = "https://api.twitter.com/1.1/statuses/show.json", 	

  Keys = twitterminer_source:get_account_keys(account1),


  Consumer = {Keys#account_keys.api_key, Keys#account_keys.api_secret, hmac_sha1},
  AccessToken = Keys#account_keys.access_token,
  AccessTokenSecret = Keys#account_keys.access_token_secret,


  SignedParams = oauth:sign("GET", URL, [{id, Bucket_key}], Consumer, AccessToken, AccessTokenSecret),



{_, _, _, Result} = ibrowse:send_req(oauth:uri(URL, SignedParams), [], get, []), %io:format("This is it: ~p", [oauth:uri(URL, SignedParams)]),


Decorated = twitterminer_source:decorate_with_id(Result),

sort_to_tweet(Pid, Category, Decorated). %io:format("Tweet: ~p~n", [Decorated]).





sort_to_tweet(Pid, Category, {parsed_tweet, L, Tweet_body, {id, Id}}) -> 
  		case lists:keyfind(<<"retweet_count">>, 1, L) of
   		 {_, Count} -> 
					case Count > 100 of
      				true -> save_popular(Pid, Category, {parsed_tweet, L, Tweet_body, {id, Id}}), delete_tweet(Pid, Category, {parsed_tweet, L, Tweet_body, {id, Id}}) , io:format("Saved: ~p~n", [Id]);
      				false -> delete_tweet(Pid, Category, {parsed_tweet, L, Tweet_body, {id, Id}}), io:format("Deleted: ~p~n", [Id]) end;
   		 false -> false end;
sort_to_tweet(_, _, {parsed_tweet, [{_, [{L}]}], _Tweet_body, no_id}) -> case lists:keyfind(<<"code">>, 1, L) of
						{_, 88} -> lists:foreach(fun(X) -> io:format("~p minutes remaining ~n",[X]), timer:sleep(60000) end, io:format("~p minutes and ~p seconds remaining ..~n",[{X, Y}]), timer:sleep(60000) end, sort_list(lists:reverse(lists:seq(1, 15)), lists:reverse(lists:seq(1, 59))));




						%[io:format("~p minutes remaining ..~n", [X]), timer:sleep(60000) || X <- lists:reverse(lists:seq(1, 15))]; %io:format("Rate limit exceeded! Waiting for 15 minutes. ~n", []), timer:sleep(900000);
						{_, _} -> io:format("Error: ~p~n", [L]) end;
sort_to_tweet(_, _, Stuff) -> io:format("Unknown input: ~p~n", [Stuff]).





%application:ensure_all_started(twitterminer).
%twitterminer_riak:initiate_bucket_purge().

%{parsed_tweet,[{<<"errors">>,
 %                      [{[{<<"message">>,
  %                         <<"Sorry, that page does not exist">>},
   %                       {<<"code">>,34}]}]}],
    %                 "{\"errors\":[{\"message\":\"Sorry, that page does not exist\",\"code\":34}]}",
     %                no_id}


%{parsed_tweet,[{<<"errors">>,
 %                      [{[{<<"message">>,<<"Rate limit exceeded">>},
  %                        {<<"code">>,88}]}]}],
   %                  "{\"errors\":[{\"message\":\"Rate limit exceeded\",\"code\":88}]}",
    %                 no_id}

    %Tweetbody = "{\"errors\":[{\"message\":\"Rate limit exceeded\",\"code\":88}]}"



  %sort_to_text({parsed_tweet, L, _Tweet_body, {id, _Id}}) -> 
  %case lists:keyfind(<<"text">>, 1, L) of
   % {_, Text} -> Text;
    %false -> false end.

updateCategory(Category) -> list_to_atom(atom_to_list(Category) ++ "popular"). 



delete_tweet(Pid, Category, {parsed_tweet, _L, _Tweet_body, {id, Id}}) ->                                %%lägg till category
riakc_pb_socket:delete(Pid, binary(Category), list_to_binary(integer_to_list(Id)));
	delete_tweet(_, _, _) -> io:format("delete_tweet did not match: ~n", []).

save_popular(Pid, Category, {parsed_tweet, _L, Tweet_body, {id, Id}}) ->
  Obj = riakc_obj:new(binary(updateCategory(Category)), list_to_binary(integer_to_list(Id)), Tweet_body),
  riakc_pb_socket:put(Pid, Obj, [{w, 0}]);
save_popular(_, _, _) -> io:format("save