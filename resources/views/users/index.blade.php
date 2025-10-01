@extends('layouts.app')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ __('Lista de usuarios') }}</span>
            <button type="button" class="btn" style="background-color:#CC5CB8; color:white; border:none; border-radius:8px; padding:8px 16px; font-weight:500;" data-coreui-toggle="modal" data-coreui-target="#createUserModal">
        
            <svg class="icon me-2">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use>
                </svg>
                Crear Usuario
            </button>
        </div>

        <div class="card-body" style="background-color:#f8f9fa; padding:2rem;">

            {{-- Aquí se muestra el mensaje de actualización --}}
            @if (session('status'))
                <div class="alert alert-success" style="border:none; border-radius:8px; background-color:#d4edda; color:#155724; border-left:4px solid #28a745;">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="row">
                @foreach ($users as $user)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card" style="border:none; border-radius:12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition:transform 0.2s, box-shadow 0.2s; background-color:white;" 
                             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(204,92,184,0.15)'" 
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'">
                            <div class="card-body" style="padding:1.5rem;">
                                <div class="d-flex align-items-center mb-3">
                                    <div style="width:50px; height:50px; background-color:#CC5CB8; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-right:1rem;">
                                        <svg class="icon" style="color:white; width:24px; height:24px;">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="card-title mb-1" style="color:#212529; font-weight:600; margin:0;">{{ $user->name }}</h6>
                                        <small class="text-muted" style="color:#6c757d;">Usuario</small>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div style="display:flex; align-items:center; margin-bottom:0.5rem;">
                                        <svg class="icon me-2" style="color:#CC5CB8; width:16px; height:16px;">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-envelope-open') }}"></use>
                                        </svg>
                                        <span style="color:#495057; font-size:0.9rem;">{{ $user->email }}</span>
                                    </div>
                                    
                                    <div style="display:flex; align-items:center;">
                                        <svg class="icon me-2" style="color:#CC5CB8; width:16px; height:16px;">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-calendar') }}"></use>
                                        </svg>
                                        <span style="color:#6c757d; font-size:0.85rem;">Registrado: {{ $user->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($user->roles->count() > 0)
                                            <span class="badge" style="background-color:#CC5CB8; color:white; font-size:0.75rem; padding:0.25rem 0.5rem; border-radius:12px;">
                                                {{ $user->roles->count() }} {{ $user->roles->count() == 1 ? 'Rol' : 'Roles' }}
                                            </span>
                                        @else
                                            <span class="badge" style="background-color:#6c757d; color:white; font-size:0.75rem; padding:0.25rem 0.5rem; border-radius:12px;">
                                                Sin roles
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <button type="button" class="btn btn-sm" 
                                            style="background-color:#CC5CB8; color:white; border:none; border-radius:6px; padding:0.375rem 0.75rem; font-size:0.8rem; font-weight:500;"
                                            data-coreui-toggle="modal" 
                                            data-coreui-target="#rolesModal"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}">
                                        <svg class="icon me-1" style="width:14px; height:14px;">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-settings') }}"></use>
                                        </svg>
                                        Roles
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <div class="card-footer" style="background-color:#f8f9fa; border:none; border-radius:0 0 12px 12px; padding:1.5rem 2rem;">
            <style>
                .pagination .page-link {
                    color: #662a5b;
                    border-color: #662a5b;
                    background-color: white;
                    border-radius: 8px;
                    margin: 0 2px;
                    padding: 0.5rem 0.75rem;
                    font-weight: 500;
                    transition: all 0.2s;
                }
                .pagination .page-link:hover {
                    color: white;
                    background-color: #662a5b;
                    border-color: #662a5b;
                    transform: translateY(-1px);
                }
                .pagination .page-item.active .page-link {
                    color: white;
                    background-color: #662a5b;
                    border-color: #662a5b;
                    box-shadow: 0 2px 8px rgba(102, 42, 91, 0.3);
                }
                .pagination .page-item.disabled .page-link {
                    color: #6c757d;
                    background-color: #f8f9fa;
                    border-color: #dee2e6;
                }
            </style>
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal para crear usuario -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border:none; border-radius:12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="background-color:#CC5CB8; color:white; border-radius:12px 12px 0 0; border:none;">
                    <h5 class="modal-title" id="createUserModalLabel" style="font-weight:600;">Crear Nuevo Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createUserForm" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-body" style="background-color:#f8f9fa; padding:2rem;">
                        <div class="mb-3">
                            <label for="name" class="form-label" style="color:#495057; font-weight:500;">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required
                                   style="border:1px solid #dee2e6; border-radius:8px; padding:0.75rem;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label" style="color:#495057; font-weight:500;">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required
                                   style="border:1px solid #dee2e6; border-radius:8px; padding:0.75rem;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label" style="color:#495057; font-weight:500;">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required
                                   style="border:1px solid #dee2e6; border-radius:8px; padding:0.75rem;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label" style="color:#495057; font-weight:500;">Confirmar Contraseña</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required
                                   style="border:1px solid #dee2e6; border-radius:8px; padding:0.75rem;">
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:#f8f9fa; border:none; border-radius:0 0 12px 12px; padding:1.5rem 2rem;">
                        <button type="button" class="btn" data-coreui-dismiss="modal" 
                                style="background-color:#6c757d; color:white; border:none; border-radius:8px; padding:0.5rem 1.5rem; font-weight:500;">
                            Cancelar
                        </button>
                        <button type="submit" class="btn" 
                                style="background-color:#CC5CB8; color:white; border:none; border-radius:8px; padding:0.5rem 1.5rem; font-weight:500;">
                            Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para roles y permisos -->
    <div class="modal fade" id="rolesModal" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border:none; border-radius:12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="background-color:#CC5CB8; color:white; border-radius:12px 12px 0 0; border:none;">
                    <h5 class="modal-title" id="rolesModalLabel" style="font-weight:600;">Asignar Roles y Permisos</h5>
                    <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rolesForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" style="background-color:#f8f9fa; padding:2rem;">
                        <div id="userInfo" class="mb-4" style="background-color:white; padding:1rem; border-radius:8px; border-left:4px solid #CC5CB8;">
                            <p style="margin:0; color:#495057;"><strong style="color:#CC5CB8;">Usuario:</strong> <span id="userName" style="color:#212529;"></span></p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div style="background-color:white; padding:1.5rem; border-radius:8px; margin-bottom:1rem;">
                                    <h6 style="color:#CC5CB8; font-weight:600; margin-bottom:1rem; border-bottom:2px solid #CC5CB8; padding-bottom:0.5rem;">Roles</h6>
                                    <div id="rolesContainer">
                                        <!-- Los roles se cargarán dinámicamente -->
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div style="background-color:white; padding:1.5rem; border-radius:8px; margin-bottom:1rem;">
                                    <h6 style="color:#CC5CB8; font-weight:600; margin-bottom:1rem; border-bottom:2px solid #CC5CB8; padding-bottom:0.5rem;">Permisos</h6>
                                    <div id="permissionsContainer">
                                        <!-- Los permisos se cargarán dinámicamente -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:#f8f9fa; border:none; border-radius:0 0 12px 12px; padding:1.5rem 2rem;">
                        <button type="button" class="btn" data-coreui-dismiss="modal" 
                                style="background-color:#6c757d; color:white; border:none; border-radius:8px; padding:0.5rem 1.5rem; font-weight:500;">
                            Cancelar
                        </button>
                        <button type="submit" class="btn" 
                                style="background-color:#CC5CB8; color:white; border:none; border-radius:8px; padding:0.5rem 1.5rem; font-weight:500;">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Manejar el modal de roles y permisos
        document.addEventListener('DOMContentLoaded', function() {
            const rolesModal = document.getElementById('rolesModal');
            const rolesForm = document.getElementById('rolesForm');
            const userNameSpan = document.getElementById('userName');
            const rolesContainer = document.getElementById('rolesContainer');
            const permissionsContainer = document.getElementById('permissionsContainer');
            
            rolesModal.addEventListener('show.coreui.modal', function (event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                
                userNameSpan.textContent = userName;
                rolesForm.action = `/users/${userId}/roles`;
                
                // Cargar roles y permisos del usuario
                loadUserRolesAndPermissions(userId);
            });
            
            function loadUserRolesAndPermissions(userId) {
                fetch(`/users/${userId}/roles/data`)
                    .then(response => response.json())
                    .then(data => {
                        // Cargar roles
                        rolesContainer.innerHTML = '';
                        data.roles.forEach(role => {
                            const div = document.createElement('div');
                            div.className = 'form-check mb-2';
                            div.style.cssText = 'padding:0.5rem; border-radius:6px; transition:background-color 0.2s;';
                            div.innerHTML = `
                                <input class="form-check-input" type="checkbox" name="roles[]" 
                                       value="${role.id}" id="role_${role.id}" ${role.assigned ? 'checked' : ''}
                                       style="accent-color:#CC5CB8; transform:scale(1.1);">
                                <label class="form-check-label" for="role_${role.id}" 
                                       style="color:#495057; font-weight:500; margin-left:0.5rem; cursor:pointer;">
                                    ${role.name}
                                </label>
                            `;
                            rolesContainer.appendChild(div);
                        });
                        
                        // Cargar permisos
                        permissionsContainer.innerHTML = '';
                        data.permissions.forEach(permission => {
                            const div = document.createElement('div');
                            div.className = 'form-check mb-2';
                            div.style.cssText = 'padding:0.5rem; border-radius:6px; transition:background-color 0.2s;';
                            div.innerHTML = `
                                <input class="form-check-input" type="checkbox" name="permissions[]" 
                                       value="${permission.id}" id="perm_${permission.id}" ${permission.assigned ? 'checked' : ''}
                                       style="accent-color:#CC5CB8; transform:scale(1.1);">
                                <label class="form-check-label" for="perm_${permission.id}" 
                                       style="color:#495057; font-weight:500; margin-left:0.5rem; cursor:pointer;">
                                    ${permission.name}
                                </label>
                            `;
                            permissionsContainer.appendChild(div);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al cargar los datos del usuario');
                    });
            }
        });
    </script>
@endsection
