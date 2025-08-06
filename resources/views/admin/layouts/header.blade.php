<header class="header-main">
    <section class="sidebar-header bg-gray">
        <section class="d-flex justify-content-between flex-md-row-reverse px-2">
            <span id="sidebar-toggle-show" class="d-inline d-md-none pointer"><i class="fas fa-toggle-off"></i></span>
            <span id="sidebar-toggle-hide" class="d-none d-md-inline pointer"><i class="fas fa-toggle-on"></i></span>
            <span><img class="logo" src="{{asset('admin-assets/images/logo.png')}}" alt=""></span>
            <span id="menu-toggle" class="d-md-none"><i class="fas fa-ellipsis-h"></i></span>
        </section>
    </section>
    <section id="body-header" class="body-header">
        <section class="d-flex justify-content-between"> 
            <section>
                <span class="mx-5">
                    <span id="search-area" class="search-area d-none">
                        <i id="search-area-hide" class="fas fa-times pointer"></i>
                        <input id="search-input" type="text" class="search-input">
                        <i class="fas fa-search pointer"></i>
                    </span>
                    <i id="search-toggle" class="fas fa-search p-1 d-none d-md-inline pointer"></i>
                </span>
                <span id="full-screen" class="pointer d-none d-md-inline">
                    <i id="screen-compress" class="fas fa-compress d-none"></i>
                    <i id="screen-expand" class="fas fa-expand"></i>
                </span>
            </section>
            <section class="">
                <span class="ms-2 ms-md-4 position-relative">
                    <span id="header-notification-toggle" class="pointer">
                        <i class="far fa-bell"></i>
                        @if($notifications->count() !== 0)
                            <sup id="notifNum" class="badge bg-danger">{{$notifications->count()}}</sup>
                        @endif
                    </span>
                    <section id="header-notification" class="header-notification rounded">
                        <section class="d-flex justify-content-between">
                            <span class="px-2">نوتیفیکیشن ها</span>
                            <span class="px-2">
                                <span class="badge bg-danger">جدید</span>
                            </span>
                        </section>
                        <ul class="list-group rounded px-0">
                            @foreach($notifications as $notification)
                                <li class="d-flex list-group-item list-group-item-action">
                                    <section class="flex-grow-1 pe-1">
                                        <p class="notification-time">
                                            {{$notification->data['message']}}
                                        </p>
                                    </section>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                </span>
                <span class="ms-2 ms-md-4 position-relative">
                    <span id="header-comment-toggle" class="pointer">
                        <i class="far fa-comment-alt"></i>
                        @if($unseenComments->count() !== 0)
                            <sup class="badge bg-danger">{{$unseenComments->count()}}</sup>
                        @endif
                    </span>
                    <section id="header-comment" class="header-comment rounded">
                        <section class="border-bottom px-4">
                            <input type="text" class="form-control form-control-sm my-4" placeholder="جستجو">
                        </section>
                        <section class="header-comment-wrapper">
                            <ul class="list-group rounded px-0">
                                @foreach($unseenComments as $unseenComment)
                                    <li class="list-group-item list-group-item-action d-flex">
                                        <div class="flex-shrink-0">
                                            <img src="{{asset('admin-assets/images/425725760_234392.jpg')}}" class="notification-img" alt="avatar">
                                        </div>
                                        <section class="flex-grow-1 pe-1 d-flex justify-content-between">
                                            <h5 class="comment-user">{{$unseenComment->user->fullName}}</h5>
                                            <span>
                                                {{Str::limit($unseenComment->body, 5)}}<i class="fas fa-circle text-success comment-user-status"></i>
                                            </span>
                                        </section>
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    </section>

                </span>
                <span class="ms-3 ms-md-5 position-relative">
                    <span id="header-profile-toggle" class="pointer">
                        <img class="header-avatar" src="{{asset('admin-assets/images/425725760_234392.jpg')}}" alt="">
                        <span class="header-username">آسیه سهرابی</span>
                        <i class="fas fa-angle-down"></i>
                    </span>
                    <section id="header-profile" class="header-profile rounded">
                        <section class="list-group rounded">
                            <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-cog"></i>تنظیمات
                            </a>
                            <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-user"></i>کاربر
                            </a>
                            <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="far fa-envelope"></i>پیام ها
                            </a>
                            <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-lock"></i>قفل صفحه
                            </a>
                            <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-sign-out-alt"></i>خروج
                            </a>
                        </section>
                    </section>
                </span>    
            </section>
        </section>
    </section>
</header>