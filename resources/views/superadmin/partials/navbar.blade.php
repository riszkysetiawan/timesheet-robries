   <!--  BEGIN NAVBAR  -->
   <div class="header-container container-xxl">
       <header class="header navbar navbar-expand-sm expand-header">
           <a href="javascript:void(0);" class="sidebarCollapse">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                   stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                   class="feather feather-menu">
                   <line x1="3" y1="12" x2="21" y2="12"></line>
                   <line x1="3" y1="6" x2="21" y2="6"></line>
                   <line x1="3" y1="18" x2="21" y2="18"></line>
               </svg>
           </a>


           <ul class="navbar-item flex-row ms-lg-auto ms-0">


               <li class="nav-item theme-toggle-item">
                   <a href="javascript:void(0);" class="nav-link theme-toggle">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                           fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                           stroke-linejoin="round" class="feather feather-moon dark-mode">
                           <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                       </svg>
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                           fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                           stroke-linejoin="round" class="feather feather-sun light-mode">
                           <circle cx="12" cy="12" r="5"></circle>
                           <line x1="12" y1="1" x2="12" y2="3"></line>
                           <line x1="12" y1="21" x2="12" y2="23"></line>
                           <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                           <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                           <line x1="1" y1="12" x2="3" y2="12"></line>
                           <line x1="21" y1="12" x2="23" y2="12"></line>
                           <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                           <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                       </svg>
                   </a>
               </li>



               <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                   <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <div class="avatar-container">
                           <div class="avatar avatar-sm avatar-indicators avatar-online">
                               @if (Auth::user()->foto && Storage::exists('public/' . Auth::user()->foto))
                                   <!-- Tampilkan foto yang diunggah pengguna -->
                                   <img alt="avatar" src="{{ Storage::url(Auth::user()->foto) }}"
                                       class="rounded-circle" />
                               @else
                                   <!-- Tampilkan avatar default jika pengguna tidak memiliki foto -->
                                   <img alt="avatar" src="{{ asset('logo.jpg') }}" class="rounded-circle" />
                               @endif
                           </div>
                       </div>
                   </a>

                   <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                       <div class="user-profile-section">
                           <div class="media mx-auto">
                               <div class="emoji me-2">&#x1F44B;</div>
                               <div class="media-body">
                                   <h5>{{ Auth::user()->nama }}</h5>
                                   <h5>{{ Auth::user()->role->nama }}</h5>
                               </div>
                           </div>
                       </div>
                       <div class="dropdown-item">
                           <a href="{{ route('profile.superadmin') }}">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                   stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                   <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                   <circle cx="12" cy="7" r="4"></circle>
                               </svg>
                               <span>Profile</span>
                           </a>
                       </div>
                       <div class="dropdown-item">
                           <a href="javascript:void(0);" id="logoutBtn">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                   stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                   <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                   <polyline points="16 17 21 12 16 7"></polyline>
                                   <line x1="21" y1="12" x2="9" y2="12"></line>
                               </svg>
                               <span>Log Out</span>
                           </a>
                       </div>

                   </div>
               </li>
           </ul>
       </header>
   </div>
   <!--  END NAVBAR  -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
       document.getElementById('logoutBtn').addEventListener('click', function(e) {
           e.preventDefault();

           Swal.fire({
               title: 'Apakah Anda yakin?',
               text: "Anda akan logout dari akun ini!",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Ya, logout!',
               cancelButtonText: 'Batal'
           }).then((result) => {
               if (result.isConfirmed) {
                   window.location.href = "{{ route('logout.superadmin') }}";
               }
           });
       });
   </script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
