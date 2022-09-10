# Matrix Messager Back-end


## Websocket

### Server

Include in the httpd.conf:

```
  LoadModule proxy_wstunnel_module modules/mod_proxy_wstunnel.so

  <VirtualHost *:*>
      ProxyRequests On
      ProxyVia On
  </VirtualHost>
```