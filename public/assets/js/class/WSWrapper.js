window.WSWrapper = (function ()
{
    function msg(type, data)
    {
        return JSON.stringify({
            type:type,
            data:data
        });
    }

    function WSWrapper(url, token)
    {
        this._ws = null;

        this._url = url;
        this._token = token;

        this._openListener = this._open.bind(this);
        this._messageListener = this._message.bind(this);
        this._closeListener = this._close.bind(this);
    }

    var p = WSWrapper.prototype;
    createjs.EventDispatcher.initialize(p);

    p.connect = function ()
    {
        if(this._ws !== null) this.close();

        this._ws = new WebSocket(this._url);
        this._ws.onopen = this._openListener;
        this._ws.onmessage = this._messageListener;
        this._ws.onclose = this._closeListener;
    };

    p.send = function (type, data)
    {
        var msgStr = msg(type, data);
        console.log("Sending: " + msgStr);
        this._ws.send(msgStr);
    };

    p.close = function ()
    {
        this._ws.close();
        this._ws = null;
    };

    p._open = function (event)
    {
        this._ws.send(msg('auth', this._token));
    };

    p._message = function (event)
    {
        var json = JSON.parse(event.data),
            type = json.type,
            error = json.error,
            data = json.data;

        console.log("Received: " + event.data);

        switch(type)
        {
            case 'auth':
                this.dispatchEvent({
                    type:"open",
                    data:data
                });
                break;
            default:
                this.dispatchEvent({
                    type:"message",
                    messageType:type,
                    error:error,
                    data:data
                });
                break;
        }
    };

    p._close = function (event)
    {
        var reason;
        if(event.code == 1000) {
            reason = "Normal closure, meaning that the purpose for which the connection was established has been fulfilled.";
        } else if(event.code == 1001) {
            reason = 'An endpoint is \"going away\", such as a server going down or a browser having navigated away from a page.';
        } else if(event.code == 1002) {
            reason = "An endpoint is terminating the connection due to a protocol error";
        } else if(event.code == 1003) {
            reason = "An endpoint is terminating the connection because it has received a type of data it cannot accept (e.g., an endpoint that understands only text data MAY send this if it receives a binary message).";
        } else if(event.code == 1004) {
            reason = "Reserved. The specific meaning might be defined in the future.";
        } else if(event.code == 1005) {
            reason = "No status code was actually present.";
        } else if(event.code == 1006) {
            reason = "Abnormal error, e.g., without sending or receiving a Close control frame";
        } else if(event.code == 1007) {
            reason = "An endpoint is terminating the connection because it has received data within a message that was not consistent with the type of the message (e.g., non-UTF-8 [http://tools.ietf.org/html/rfc3629] data within a text message).";
        } else if(event.code == 1008) {
            reason = "An endpoint is terminating the connection because it has received a message that \"violates its policy\". This reason is given either if there is no other sutible reason, or if there is a need to hide specific details about the policy.";
        } else if(event.code == 1009) {
            reason = "An endpoint is terminating the connection because it has received a message that is too big for it to process.";
        } else if(event.code == 1010) { // Note that this status code is not used by the server, because it can fail the WebSocket handshake instead.
            reason = "An endpoint (client) is terminating the connection because it has expected the server to negotiate one or more extension, but the server didn't return them in the response message of the WebSocket handshake. <br /> Specifically, the extensions that are needed are: " + event.reason;
        } else if(event.code == 1011) {
            reason = "A server is terminating the connection because it encountered an unexpected condition that prevented it from fulfilling the request.";
        } else if(event.code == 1015) {
            reason = "The connection was closed due to a failure to perform a TLS handshake (e.g., the server certificate can't be verified).";
        } else {
            reason = "Unknown reason";
        }

        this.dispatchEvent({
            type:"close",
            code:event.code,
            reason:reason
        });

        this._ws.onopen = null;
        this._ws.onmessage = null;
        this._ws.onclose = null;
        this._ws = null;
    };

    return WSWrapper;
}());