@if (session('toast-success'))
    <section class="toast" data-bs-delay="5000">
        <section class="toast-body py-3 d-flex bg-success text-white">
            <strong class="ms-auto"> {{session('toast-success')}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </section>
    </section>

    <script>
        // var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        // var toastList = toastElList.map(function (toastEl) {
        // return new bootstrap.Toast(toastEl, option)
        // })

        $(document).ready(function(){
            $('.toast').toast('show');
        })
    </script>
@endif