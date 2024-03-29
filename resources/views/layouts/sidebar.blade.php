<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('image') }}/logo.png" alt="Zie Rules Logo" class="brand-image bg-white img-circle">
        <span class="brand-text font-weight-light">Zie Rules</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">

                @if (auth()->guard('web')->check())
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon icon fa-solid fa-chart-simple"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon icon fa-solid fa-calendar-xmark"></i>
                                <p>
                                    Pelanggaran
                                    <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view-any', App\Models\Violation::class)
                                    <li class="nav-item">
                                        <a href="{{ route('violations.index') }}" class="nav-link">
                                            <p>Jenis Pelanggaran</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\DataViolation::class)
                                    <li class="nav-item">
                                        <a href="{{ route('data-violations.index') }}" class="nav-link">
                                            <p>Data Pelanggaran</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon icon fa-solid fa-trophy"></i>
                                <p>
                                    Prestasi
                                    <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view-any', App\Models\Achievment::class)
                                    <li class="nav-item">
                                        <a href="{{ route('achievments.index') }}" class="nav-link">

                                            <p>Jenis Prestasi</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\DataAchievment::class)
                                    <li class="nav-item">
                                        <a href="{{ route('data-achievments.index') }}" class="nav-link">

                                            <p>Data Prestasi</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon icon fa-solid fa-list-check"></i>

                                <p>
                                    Tugas
                                    <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view-any', App\Models\Task::class)
                                    <li class="nav-item">
                                        <a href="{{ route('tasks.index') }}" class="nav-link">
                                            <p>Jenis Tugas</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\DataTask::class)
                                    <li class="nav-item">
                                        <a href="{{ route('data-tasks.index') }}" class="nav-link">
                                            <p>Data Tugas</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon icon fas fa-cubes"></i>


                                <p>
                                    Kehadiran
                                    <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view-any', App\Models\Presence::class)
                                    <li class="nav-item">
                                        <a href="{{ route('presences.index') }}" class="nav-link">
                                            <p>Jenis Kehadiran</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\StudentAbsence::class)
                                    <li class="nav-item">
                                        <a href="{{ route('student-absences.index') }}" class="nav-link">
                                            <p>Kehadiran Siswa</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon icon fa-solid fa-users"></i>

                                <p>
                                    Identitas
                                    <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view-any', App\Models\Student::class)
                                    <li class="nav-item">
                                        <a href="{{ route('students.index') }}" class="nav-link">
                                            <p>Data Siswa</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\Teacher::class)
                                    <li class="nav-item">
                                        <a href="{{ route('teachers.index') }}" class="nav-link">
                                            <p>Data Guru</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\Homeroom::class)
                                    <li class="nav-item">
                                        <a href="{{ route('homerooms.index') }}" class="nav-link">
                                            <p>Data Wali Kelas</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\ClassStudent::class)
                                    <li class="nav-item">
                                        <a href="{{ route('class-students.index') }}" class="nav-link">
                                            <p>Data Kelas</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon icon fa-solid fa-qrcode"></i>

                                <p>
                                    Catatan Scan
                                    <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view-any', App\Models\HistoryAchievment::class)
                                    <li class="nav-item">
                                        <a href="{{ route('history-achievments.index') }}" class="nav-link">
                                            <p>Catatan Scan Prestasi</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\HistoryTask::class)
                                    <li class="nav-item">
                                        <a href="{{ route('history-tasks.index') }}" class="nav-link">
                                            <p>Catatan Scan Tugas</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\HistoryViolation::class)
                                    <li class="nav-item">
                                        <a href="{{ route('history-violations.index') }}" class="nav-link">
                                            <p>Catatan Scan Pelanggaran</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon icon fa-solid fa-list"></i>
                                <p>
                                    Lainnya
                                    <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view-any', App\Models\Article::class)
                                    <li class="nav-item">
                                        <a href="{{ route('articles.index') }}" class="nav-link">
                                            <p>Artikel</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\Quote::class)
                                    <li class="nav-item">
                                        <a href="{{ route('quotes.index') }}" class="nav-link">
                                            <p>Quote</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\User::class)
                                    <li class="nav-item">
                                        <a href="{{ route('users.index') }}" class="nav-link">
                                            <p>User</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\Version::class)
                                    <li class="nav-item">
                                        <a href="{{ route('versions.index') }}" class="nav-link">
                                            <p>Versi</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon icon fa-solid fa-folder-open"></i>
                                <p>
                                    Laporan
                                    <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view-any', App\Models\DataViolation::class)
                                    <li class="nav-item">
                                        <a href="{{ route('data.violations.report') }}" class="nav-link">
                                            <p>Laporan Pelanggaran</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\DataAchievment::class)
                                    <li class="nav-item">
                                        <a href="{{ route('data.achievments.report') }}" class="nav-link">
                                            <p>Laporan Prestasi</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\DataTask::class)
                                    <li class="nav-item">
                                        <a href="{{ route('data.tasks.report') }}" class="nav-link">
                                            <p>Laporan Tugas</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view-any', App\Models\StudentAbsence::class)
                                    <li class="nav-item">
                                        <a href="{{ route('data.absence.report') }}" class="nav-link">
                                            <p>Laporan Kehadiran</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) ||
                                Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="aav-icon icon fa-solid fa-key"></i>
                                    <p>
                                        Hak Akses
                                        <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('view-any', Spatie\Permission\Models\Role::class)
                                        <li class="nav-item">
                                            <a href="{{ route('roles.index') }}" class="nav-link">
                                                <p>Role</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view-any', Spatie\Permission\Models\Permission::class)
                                        <li class="nav-item">
                                            <a href="{{ route('permissions.index') }}" class="nav-link">
                                                <p>Akses</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif
                    @endauth
                @else
                    <li class="nav-item">
                        <a href="{{ route('parent.home') }}" class="nav-link">
                            <i class="nav-icon icon fa-solid fa-chart-simple"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>
                @endif


                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="nav-icon icon fa-solid fa-right-from-bracket"></i>
                            <p>{{ __('Logout') }}</p>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
