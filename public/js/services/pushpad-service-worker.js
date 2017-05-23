self.addEventListener('push', function(event) {  
  event.waitUntil(
    self.registration.pushManager.getSubscription().then(function(subscription) {
      var notificationsPath = 'https://pushpad.xyz/notifications?endpoint=' + encodeURIComponent(subscription.endpoint);
      var headers = new Headers();
      headers.append('Accept', 'application/json');
      return fetch(notificationsPath, {headers: headers}).then(function(response) {
        if (response.status !== 200) {  
          throw new Error('The API returned an error. Status Code: ' + response.status);
        }
        return response.json().then(function(notifications) {
          return Promise.all(
            notifications.map(function (notification) {
              return self.registration.showNotification(notification.title, {  
                body: notification.body,
                icon: 'https://pushpad.xyz' + notification.icon_url,
                tag: notification.id,
                requireInteraction: notification.require_interaction
              });
            })
          );
        });  
      }).catch(function(err) {  
        console.error('Unable to retrieve notifications.', err);
      });
    })
  );  
});

self.addEventListener('notificationclick', function(event) {
  // Android doesn't close the notification when you click on it  
  // See: http://crbug.com/463146  
  event.notification.close();

  event.waitUntil(
    self.registration.pushManager.getSubscription().then(function(subscription) {
      var targetUrl = 'https://pushpad.xyz/notifications/' + event.notification.tag + '/redirect?endpoint=' + encodeURIComponent(subscription.endpoint);
      return clients.openWindow(targetUrl);
    })
  );
});