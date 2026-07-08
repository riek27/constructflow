<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ConstructFlow') }} – Commercial Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#1E3A5F',
                        emerald: {
                            50: '#ECFDF5',
                            100: '#D1FAE5',
                            200: '#A7F3D0',
                            300: '#6EE7B7',
                            400: '#34D399',
                            500: '#10B981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065F46',
                            900: '#064E3B',
                        },
                        surface: '#F8FAFC',
                        'dark-slate': '#1F2937',
                    },
                },
            },
        }
    </script>

    <!-- Alpine.js CDN (for dropdowns and mobile sidebar) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom CSS -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-bg { background: linear-gradient(180deg, #12345A 0%, #0F2748 100%); }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.75rem;
            color: #F8FAFC;
            border-bottom: 1px solid rgba(255,255,255,.08);
            transition: all 0.2s ease;
        }
        .sidebar-link svg {
            width: 22px;
            height: 22px;
            color: #D1D5DB;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            background: #2C4D79;
            color: #FFFFFF;
            transform: translateX(3px);
        }
        .sidebar-link:hover svg {
            color: #FFFFFF;
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, #0F9D8A 0%, #10B981 100%);
            color: #FFFFFF;
            font-weight: 600;
            border-left: 4px solid #34D399;
            border-bottom-color: transparent;
            box-shadow: 0 8px 24px rgba(16,185,129,.25);
        }
        .sidebar-link.active svg {
            color: #FFFFFF;
        }
        .sidebar-link:focus-visible {
            outline: 2px solid #34D399;
            outline-offset: 2px;
        }
        .sidebar-footer {
            color: #94A3B8;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        body.mobile-sidebar-open { overflow: hidden; }
    </style>
</head>
<body x-data="{ sidebarOpen: false }" :class="{ 'mobile-sidebar-open': sidebarOpen }" class="font-sans antialiased">
    <div class="min-h-screen flex bg-gray-100">

        <!-- Mobile backdrop (visible only when sidebar open) -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden" x-cloak></div>

        <!-- Sidebar (shared between mobile and desktop) -->
        <div
            @click.outside="sidebarOpen = false"
            class="fixed inset-y-0 left-0 z-30 w-64 sidebar-bg overflow-y-auto transform transition-transform duration-300 lg:relative lg:flex lg:flex-col lg:inset-y-0 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex flex-col flex-grow sidebar-bg overflow-y-auto">
                <!-- Logo -->
                <div class="flex items-center h-16 px-6 bg-navy border-b border-gray-700">
                    <svg class="h-8 w-8 text-emerald-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-white font-bold text-lg">ConstructFlow</span>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-4 space-y-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Projects
                    </x-nav-link>
@can('manage users')
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </x-nav-link>
@endcan
@can('manage contracts')
                    <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.*')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Contracts
                    </x-nav-link>
@endcan
@can('manage variations')
                    <x-nav-link :href="route('variations.index')" :active="request()->routeIs('variations.*')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Variations
                    </x-nav-link>
@endcan
@can('manage payments')
                    <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Payments
                    </x-nav-link>
@endcan
@can('manage procurement')
                    <x-nav-link :href="route('procurements.index')" :active="request()->routeIs('procurements.*')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                        Procurement
                    </x-nav-link>
@endcan
@can('manage documents')
                    <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.*')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Documents
                    </x-nav-link>
@endcan
@can('manage reports')
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Reports
                    </x-nav-link>
@endcan
@can('view activity logs')
                    <x-nav-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.*')" class="sidebar-link">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Activity Logs
                    </x-nav-link>
@endcan
                </nav>

                <!-- Sidebar footer -->
                <div class="px-4 py-4 sidebar-footer">
                    <div class="text-xs">© {{ date('Y') }} ConstructFlow</div>
                </div>
            </div>
        </div>

        <!-- Main content area -->
        <div class="flex flex-col flex-1 lg:pl-64">
            <!-- Top header (hamburger for mobile, profile) -->
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow-sm">
                <button @click="sidebarOpen = !sidebarOpen" type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500 lg:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="flex-1 px-4 flex justify-end">
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Profile dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
