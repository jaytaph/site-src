---
title: "[Tips] Non blocking long api call"
date: 2021-04-05
hero: https://images.unsplash.com/photo-1545987796-200677ee1011?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=300&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&w=1600&q=80
state: published
---

If you have to make some external API call during a process, but you have no need to wait the response to return result to the user, this tip can help you:

<div data-controller="tweet-embed" data-tweet-embed-id-value="1379011895915593728"></div>

On Symfony, the `kernel.terminate` event is launched after the response has been sent to the user.

The response from [symfony/http-client](https://github.com/symfony/http-client) is by design asynchronous, but when the object is destroyed, it'll wait the request is completed (see [here](https://github.com/symfony/http-client/blob/5.3/Response/AsyncResponse.php#L176-L182)).

By keep the response instance and using it in `kernel.terminate` event, we don't have to wait the request is completed before render result to user.

<div data-controller="tweet-embed" data-tweet-embed-id-value="1379011900588052482"></div>

If you use Laravel >= 8.x, you can also dispatch event after response is sent :

<div data-controller="tweet-embed" data-tweet-embed-id-value="1379057717051064322" data-tweet-embed-conv-value="true"></div>
