# AppPresser Custom Push
An example WordPress plugin of how to customize push notification sent through your myapppresser.com account.

Takes advantage of the 'ap3_send_push_data' filter in AppPush to customize the push data.  This example customizes the title and message for iOS and Android separately and adds the featured image of a post to the data, but only for Android.

The data to be customized is the payload used by the phonegap-push-plugin[https://github.com/phonegap/phonegap-plugin-push/blob/master/docs/PAYLOAD.md].
