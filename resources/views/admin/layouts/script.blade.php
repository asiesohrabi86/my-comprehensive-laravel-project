    <script src="{{asset('admin-assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin-assets/js/popper.min.js')}}"></script>
    // <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="{{asset('admin-assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin-assets/js/grid.js')}}"></script>
    <script src="{{asset('admin-assets/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('admin-assets/sweetalert/sweetalert2.min.js')}}"></script>

    <script>
        let notificationDropdown = document.getElementById('header-notification-toggle');
        let notifNum = document.getElementById('notifNum');
        notificationDropdown.addEventListener('click', function(){
            $.ajax({
                type: "POST",
                url: "/admin/notification/read-all",
                data: {_token: "{{csrf_token()}}"},
                success: function(){
                    console.log('yes');
                }
            })

            
            // const res = fetch('http://localhost:8000/admin/notification/read-all', {
            //     method: "POST",
            //     headers: {
            //         'Content_Type': 'application/json'
            //     },
            //     body: JSON.stringify({_token: "{{csrf_token()}}"})
            // }).then(res =>res.json())
            // .then(result => console.log(result))
            // .catch(error => console.log(error));
        });
    </script>
   