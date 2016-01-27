# Channels

Channels serve as the home location for a [user's][users] content. Channels have a [stream][streams], can run commercials, store [videos][], display information and status, and have a customized page including banners and backgrounds.

| Endpoint | Description |
| ---- | --------------- |
| [GET /channels/:channel](/v2_resources/channels.md#get-channelschannel) | Get channel object|
| [GET /channel](/v2_resources/channels.md#get-channel) | Get channel object |
| [GET /channels/:channel/editors](/v2_resources/channels.md#get-channelschanneleditors) | Get channel's list of editors |
| [PUT /channels/:channel](/v2_resources/channels.md#put-channelschannel) | Update channel object |
| [GET /channels/:channel/videos](/v2_resources/channels.md#get-channelschannelvideos) | Get channel's list of videos |
| [GET /channels/:channel/follows](/v2_resources/channels.md#get-channelschannelfollows) | Get channel's list of following users |
| [DELETE /channels/:channel/stream_key](/v2_resources/channels.md#delete-channelschannelstream_key) | Reset channel's stream key |
| [POST /channels/:channel/commercial](/v2_resources/channels.md#post-channelschannelcommercial) | Start a commercial on channel |

[users]: /v2_resources/users.md
[streams]: /v2_resources/streams.md
[videos]: /v2_resources/videos.md

## `GET /channels/:channel`

Returns a channel object.

### Example Request

```bash
curl -H 'Accept: application/vnd.twitchtv.v2+json' \
-X GET https://api.twitch.tv/kraken/channels/test_user1
```

### Example Response

```json
{
  "name": "test_user1",
  "game": "World of Warcraft: Cataclysm",
  "created_at": "2011-02-24T01:38:43Z",
  "title": "test_user1",
  "updated_at": "2012-06-18T05:22:53Z",
  "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-channel_header_image-7d10ec1bfbef2988-640x125.png",
  "video_banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-channel_offline_image-bdcb1260130fa0cb.png",
  "background": null,
  "_links": {
    "self": "https://api.twitch.tv/kraken/channels/test_user1",
    "chat": "https://api.twitch.tv/kraken/chat/test_user1",
    "videos": "https://api.twitch.tv/kraken/channels/test_user1/videos",
    "commercial": "https://api.twitch.tv/kraken/channels/test_user1/commercial",
    "follows":"https://api.twitch.tv/kraken/channels/test_user1/follows",
    "stream_key":"https://api.twitch.tv/kraken/channels/test_user1/stream_key",
    "features":"https://api.twitch.tv/kraken/channels/test_user1/features",
    "subscriptions":"https://api.twitch.tv/kraken/channels/test_user1/subscriptions",
    "editors":"https://api.twitch.tv/kraken/channels/test_user1/editors"
  },
  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-profile_image-7243b004a2ec3720-300x300.png",
  "_id": 20694610,
  "mature": true,
  "url": "http://www.twitch.tv/test_user1",
  "display_name": "test_user1",
  "teams": [{
    "name": "staff",
    "created_at": "2011-10-25T23:55:47Z",
    "updated_at": "2011-11-14T19:48:21Z",
    "background": null,
    "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-staff-banner_image-1e028d6b6aec8e6a-640x125.jpeg",
    "logo": null,
    "_links": {
      "self": "https://api.twitch.tv/kraken/teams/staff"
    },
    "_id": 10,
    "info": "We save the world..",
    "display_name": "TwitchTV Staff"
  }]
}
```

## `GET /channel`

Returns a channel object of authenticated user. Channel object includes stream key.

*__Authenticated__*, required scope: `channel_read`

### Example Request

```bash
curl -H 'Accept: application/vnd.twitchtv.v2+json' -H 'Authorization: OAuth <access_token>' \
-X GET https://api.twitch.tv/kraken/channel
```

### Example Response

```json
{
  "game": "Diablo II: Lord of Destruction",
  "name": "test_user1",
  "stream_key": "live_21229404_abcdefg",
  "created_at": "2011-03-19T15:42:22Z",
  "title": "Cev",
  "updated_at": "2012-03-14T03:30:41Z",
  "teams": [{
    "name": "staff",
    "created_at": "2011-10-25T23:55:47Z",
    "updated_at": "2011-11-14T19:48:21Z",
    "background": null,
    "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-staff-banner_image-1e028d6b6aec8e6a-640x125.jpeg",
    "logo": null,
    "_links": {
      "self": "https://api.twitch.tv/kraken/teams/staff"
    },
    "_id": 10,
    "info": "We save the world..",
    "display_name": "TwitchTV Staff"
  }],
  "_links": {
    "self": "https:/api.twitch.tv/kraken/channels/test_user1",
    "chat":"https:/api.twitch.tv/kraken/chat/test_user1",
    "videos": "https://api.twitch.tv/kraken/channels/test_user1/videos",
    "video_status": "https://api.twitch.tv/kraken/channels/test_user1/video_status",
    "commercial":"https:/api.twitch.tv/kraken/channels/test_user1/commercial"
  },
  "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-channel_header_image-7d10ec1bfbef2988-640x125.png",
  "video_banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-channel_offline_image-bdcb1260130fa0cb.png",
  "background": null,
  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-profile_image-7243b004a2ec3720-300x300.png",
  "_id": 21229404,
  "mature": false,
  "login": "test_user1",
  "url": "http://www.twitch.tv/test_user1",
  "email": "test_user1@justin.tv"
}
```

## `GET /channels/:channel/videos`

See the [Videos](/v2_resources/videos.md#get-channelschannelvideos) resource.

## `GET /channels/:channel/follows`

See the [Follows](/v2_resources/follows.md#get-channelschannelfollows) resource.

## `GET /channels/:channel/editors`

Returns a list of user objects who are editors of `:channel`.

*__Authenticated__*, required scope: `channel_read`

### Example Request

```bash
curl -H 'Accept: application/vnd.twitchtv.v2+json' -H 'Authorization: OAuth <access_token>' \
-X GET https://api.twitch.tv/kraken/channels/test_user1/editors
```

### Example Response

```json
{
  "_links": {
    "self": "http://api.twitch.tv/kraken/channels/test_user1/editors"
  },
  "users": [
    {
      "_links": {
        "self": "http://staging.twitch.tv/kraken/users/test_user_editor1"
      },
      "created_at": "2013-02-06T21:21:57Z",
      "name": "test_user_editor1",
      "updated_at": "2013-02-13T20:59:42Z",
      "_id": 40091581,
      "display_name": "test_user_editor1",
      "logo": null,
      "staff": false
    },
    ...
  ]
}
```

## `PUT /channels/:channel/`

Update channel's status or game.

*__Authenticated__*, required scope: `channel_editor`

### Parameters

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Required?</th>
            <th width="50">Type</th>
            <th width=100%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>status</code></td>
            <td>optional</td>
            <td>string</td>
            <td>Channel's title.</td>
        </tr>
        <tr>
            <td><code>game</code></td>
            <td>optional</td>
            <td>string</td>
            <td>Game category to be classified as.</td>
        </tr>
    </tbody>
</table>

Form-encoded or JSON parameters specifying the properties to change. These should be under a `channel` object:

```json
{
  "channel": {
    "status": "Playing cool new game!",
    "game": "Diablo"
  }
}
```

### Example Request

```bash
curl -H 'Accept: application/vnd.twitchtv.v2+json' -H 'Authorization: OAuth <access_token>' \
-d "channel[status]=Playing+cool+new+game!&channel[game]=Diablo" \
-X PUT https://api.twitch.tv/kraken/channels/test_user1
```

### Example Response

```json
{
  "name": "test_user1",
  "game": "Diablo",
  "created_at": "2011-02-24T01:38:43Z",
  "teams": [{
    "name": "staff",
    "created_at": "2011-10-25T23:55:47Z",
    "updated_at": "2011-11-14T19:48:21Z",
    "background": null,
    "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-staff-banner_image-1e028d6b6aec8e6a-640x125.jpeg",
    "logo": null,
    "_links": {
      "self": "https://api.twitch.tv/kraken/teams/staff"
    },
    "_id": 10,
    "info": "We save the world..",
    "display_name": "TwitchTV Staff"
  }],
  "title": "Playing cool new game!",
  "updated_at": "2012-06-18T05:22:53Z",
  "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-channel_header_image-7d10ec1bfbef2988-640x125.png",
  "video_banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-channel_offline_image-bdcb1260130fa0cb.png",
  "background": null,
  "_links": {
    "self": "https://api.twitch.tv/kraken/channels/test_user1",
    "chat": "https://api.twitch.tv/kraken/chat/test_user1",
    "videos": "https://api.twitch.tv/kraken/channels/test_user1/videos",
    "video_status": "https://api.twitch.tv/kraken/channels/test_user1/video_status",
    "commercial": "https://api.twitch.tv/kraken/channels/test_user1/commercial"
  },
  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-profile_image-7243b004a2ec3720-300x300.png",
  "_id": 20694610,
  "mature": true,
  "url": "http://www.twitch.tv/test_user1",
  "display_name": "test_user1"
}
```

## `DELETE /channels/:channel/stream_key`

Resets channel's stream key.

*__Authenticated__*, required scope: `channel_stream`

### Example Request

```bash
curl -H 'Accept: application/vnd.twitchtv.v2+json' -H 'Authorization: OAuth <access_token>' \
-X DELETE https://api.twitch.tv/kraken/channels/test_user1/stream_key
```

### Example Response

`204 No Content`.

## `POST /channels/:channel/commercial`

Start commercial on channel.

*__Authenticated__*, required scope: `channel_commercial`

### Parameters

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Required?</th>
            <th width="50">Type</th>
            <th width=100%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>length</code></td>
            <td>optional</td>
            <td>integer</td>
            <td>Length of commercial break in seconds. Default value is 30. Valid values are 30, 60, 90, 120, 150, and 180. You may only trigger a commercial longer than 30 seconds once every 8 minutes.</td>
        </tr>
    </tbody>
</table>

### Example Request

```bash
curl -H 'Accept: application/vnd.twitchtv.v2+json' -H 'Authorization: OAuth <access_token>' \
-d "length=30" -X POST https://api.twitch.tv/kraken/channels/test_user1/commercial
```

### Example Response

`204 No Content` if successful.

### Errors

`422 Unprocessable Entity` if commercial length not allowed, a commercial was ran less than 8 minutes ago, or the channel is not partnered.
