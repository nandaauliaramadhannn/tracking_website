@if (config('sweetalert.alwaysLoadJS') === true || Session::has('alert.config') || Session::has('alert.delete') || Session::has('alert.toast'))
    @if (config('sweetalert.animation.enable'))
        <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    @endif

    @if (config('sweetalert.theme') != 'default')
        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-{{ config('sweetalert.theme') }}" rel="stylesheet">
    @endif

    @if (config('sweetalert.neverLoadJS') === false)
        <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @endif

    <script>
        // Custom SweetAlert configuration for better UX
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            customClass: {
                popup: 'animated fadeInRight faster',
                container: 'swal2-container'
            }
        });

        // Display toast notifications
        @if (Session::has('alert.toast'))
            const toastConfig = {!! Session::pull('alert.toast') !!};
            const defaultToastConfig = {
                icon: 'success',
                title: 'Success!',
                background: '#ffffff',
                color: '#333333',
                backdrop: false,
                showClass: {
                    popup: 'animate__animated animate__fadeInRight'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutRight'
                }
            };

            // Merge with default config
            const finalToastConfig = Object.assign(defaultToastConfig, toastConfig);
            Swal.fire(finalToastConfig);
        @endif

        // Enhanced confirm delete dialog
        @if (Session::has('alert.delete') || Session::has('alert.config'))
            document.addEventListener('click', function(event) {
                // Check if the clicked element or its parent has the attribute
                var target = event.target;
                var confirmDeleteElement = target.closest('[data-confirm-delete]');

                if (confirmDeleteElement) {
                    event.preventDefault();
                    const deleteConfig = Object.assign({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        customClass: {
                            popup: 'swal2-popup',
                            title: 'swal2-title',
                            content: 'swal2-content',
                            actions: 'swal2-actions',
                            confirmButton: 'swal2-confirm',
                            cancelButton: 'swal2-cancel'
                        }
                    }, {!! Session::pull('alert.delete') !!});

                    Swal.fire(deleteConfig).then(function(result) {
                        if (result.isConfirmed) {
                            var form = document.createElement('form');
                            form.action = confirmDeleteElement.href;
                            form.method = 'POST';
                            form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            });

            @if (Session::has('alert.config'))
                const config = Object.assign({
                    customClass: {
                        popup: 'swal2-popup',
                        title: 'swal2-title',
                        content: 'swal2-content',
                        actions: 'swal2-actions',
                        confirmButton: 'swal2-confirm',
                        cancelButton: 'swal2-cancel'
                    },
                    buttonsStyling: true
                }, {!! Session::pull('alert.config') !!});

                Swal.fire(config);
            @endif
        @endif
    </script>

    <style>
        .swal2-popup {
            border-radius: 0.75rem !important;
            font-family: system-ui, -apple-system, sans-serif !important;
        }

        .swal2-title {
            font-weight: 600 !important;
            font-size: 1.25rem !important;
        }

        .swal2-content {
            font-size: 0.95rem !important;
            color: #4b5563 !important;
        }

        .swal2-confirm {
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            padding: 0.5rem 1.5rem !important;
        }

        .swal2-cancel {
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            padding: 0.5rem 1.5rem !important;
        }

        .swal2-toast {
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .animated.fadeInRight.faster {
            animation-duration: 0.5s;
            animation-fill-mode: both;
            animation-name: fadeInRight;
        }

        .animated.fadeOutRight.faster {
            animation-duration: 0.5s;
            animation-fill-mode: both;
            animation-name: fadeOutRight;
        }
    </style>
@endif
