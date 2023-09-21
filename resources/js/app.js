import './bootstrap';

// import Alpine from 'alpinejs';
//
// window.Alpine = Alpine;
//
// Alpine.start();
//
//
// Echo.private('App.Model.User.' + userId)
// .notification(function () {
//
// })

if (classroomId) {
    Echo.private('classroom.' + classroomId)
        .listen('.classwork-created', function (event) {
            alert(event.title);
        });
}

Echo.private('Notifications.' + userId)
    .notification(function(event) {
        alert(event.body);
    });
