<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // GLobal functions
    function showModal(selector) {
        $('#'+selector).modal('show')
    }

    function hideModal(selector) {
        $('#'+selector).modal('hide')
    }

    $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });

    $(document).ready(function(){
        var dispo_count = parseInt($('.disposition_count').text())
        var exit_count = parseInt($('.exit_count').text())
        var leave_count = parseInt($('.leave_count').text())
        var outgoing_count = parseInt($('.outgoing_count').text())


        const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              height: 600,
              timer: 5000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })

        var pusher = new Pusher('9b20901b264fe57d21bd', {
          cluster: 'ap1',
          encrypted:true
        });

        let user = {!! json_encode(Auth::user()->id)!!}

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '9b20901b264fe57d21bd',
            cluster: 'ap1',
            forceTLS: true,
            wsHost: window.location.hostname,
            wsPort: 8000,
        });

        window.Echo.private('App.Models.User.' + user)
        .notification((notification) => {
            if(notification.notif_type == 'disposition'){
                dispo_count += 1
                $('.disposition_count').text(dispo_count);

                Toast.fire({
                      icon: 'info',
                      title: 'Anda mendapat ' + dispo_count + ' surat disposisi baru'
                    })
            } else if(notification.notif_type == 'exit'){
                exit_count += 1
                $('.exit_count').text(exit_count);

                Toast.fire({
                      icon: 'info',
                      title: 'Anda mendapat ' + exit_count + ' surat keluar kantor baru'
                    })
            }  else if(notification.notif_type == 'leave'){
                leave_count += 1
                $('.leave_count').text(leave_count);

                Toast.fire({
                      icon: 'info',
                      title: 'Anda mendapat ' + leave_count + ' surat cuti baru'
                    })
            }  else if(notification.notif_type == 'outgoing'){
                outgoing_count += 1
                $('.outgoing_count').text(outgoing_count);

                Toast.fire({
                      icon: 'info',
                      title: 'Anda mendapat ' + outgoing_count + ' surat keluar baru'
                    })
            }

        });

    });

        // var channel = pusher.subscribe('my-channel');
        // channel.bind('App\\Events\\DispositionNotif', function(data) {
        //     if(data){
        //         Toast.fire({
        //           icon: 'info',
        //           title: data.message
        //         })
        //     }
        // });

</script>
