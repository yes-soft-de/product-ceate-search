# Backend API

Based on Kenan's work and Talal Choice of Elastic Search Consumer 



## How to Run

1. Run Elastic Search
2. On Power shell on the Project Base Folder `composer update`
3. `php bin/console server:run`
4. Congrats it's working 
5. Use `Post Man` for now  and create `JSON` Post Request with the fallowing body

```
{
	"query": "hello world My name is Mohammad"
}
```

5. in `PrintingSearchController` line `22` I created a `TODO` please do the following 

   1. explode the phrase to keywords
   2. add the keywords to a match query
   3. the match query is explained in Document https://github.com/yes-soft-de/logging-flow/tree/elastic_search
   4. <b>the final `$params` should be like </b>

   ```
   $params = [
                   'index' => 'yes_topic',
                   'body' => [
                       'query' => [
                           'match' => [
                               'message' => 'Hello'
                           ],'match' => [
                           	'message' => 'world'
                           ] ,'match' => [
                           	'message' => 'my'
                           ] ,'match' => [
                           	'message' => 'name'
                           ] ,'match' => [
                           	'message' => 'is'
                           ] ,'match' => [
                           	'message' => 'mohammad'
                           ] 
                       ]
                   ]
               ];
   ```

   5. the <b>Original</b> response is Like this:

   ```
   {
       "data": {
           "took": 77,
           "timed_out": false,
           "_shards": {
               "total": 1,
               "successful": 1,
               "skipped": 0,
               "failed": 0
           },
           "hits": {
               "total": {
                   "value": 3,
                   "relation": "eq"
               },
               "max_score": 1.251696,
               "hits": [
                   {
                       "_index": "yes_topic",
                       "_type": "_doc",
                       "_id": "oq3Un2sB17cMIC5oWUIf",
                       "_score": 1.251696,
                       "_source": {
                           "message": "Hello",
                           "@timestamp": "2019-06-28T20:43:41.417Z",
                           "@version": "1"
                       }
                   },
                   {
                       "_index": "yes_topic",
                       "_type": "_doc",
                       "_id": "nq19n2sB17cMIC5oYUJY",
                       "_score": 1.0286214,
                       "_source": {
                           "message": "Hello",
                           "@timestamp": "2019-06-28T19:08:41.402Z",
                           "@version": "1"
                       }
                   },
                   {
                       "_index": "yes_topic",
                       "_type": "_doc",
                       "_id": "n62Dn2sB17cMIC5o2EJS",
                       "_score": 1.0286214,
                       "_source": {
                           "message": "Hello Again",
                           "@timestamp": "2019-06-28T19:15:46.252Z",
                           "@version": "1"
                       }
                   }
               ]
           }
       }
   }
   ```

   6. <b>Please Extract Only the `Hits` and Return it as JSON</b>
   
## Contact Me AS SOON AS THIS IS DONE