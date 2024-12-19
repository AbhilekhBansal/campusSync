@php
$container = 'container-xxl';
$containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Admins')

@section('content')
<!-- Layout Demo -->



<!-- Content -->
<div class="col-xxl-8 flex-grow-1 ">
    <div class="row g-6 mb-6">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Admins</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{count($admins)}}</h4>

                                {{-- <p class="text-success mb-0">(+29%)</p> --}}
                            </div>
                            <small class="mb-0">Total Admins</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-group bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Paid Users</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">4,567</h4>
                                <p class="text-success mb-0">(+18%)</p>
                            </div>
                            <small class="mb-0">Last week analytics </small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-user-plus bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Active Admins</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $admins->filter(fn($admin) => $admin->admin['status'] ===
                                    1)->count() }}</h4>
                                <p class="text-success mb-0">({{($admins->filter(fn($admin) => $admin->admin['status']
                                    ===
                                    1)->count()/count($admins)*100)}}%)</p>
                            </div>
                            <small class="mb-0">Total Admins ({{count($admins)}})</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-user-check bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Pending Users</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">237</h4>
                                <p class="text-success mb-0">(+42%)</p>
                            </div>
                            <small class="mb-0">Last week analytics</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-user-voice bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Users List Table -->
    <div class="card">
        <div class=" flex">

            <h5 class="card-header flex-1">Admin List</h5>
            <button type="button" class="btn btn-primary p-2 m-auto !mr-2" data-bs-toggle="modal"
                data-bs-target="#basicModal">
                <i class="fas fa-plus mr-2"></i> Add Admin
            </button>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 " id="adminsList">
                    @foreach ($admins as $index => $admin)

                    <tr id="adminlist-{{$admin->id}}">
                        <td><span>{{$index+1}}</span></td>
                        <td>
                            <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    class="avatar avatar-sm mr-3" title="Lilian Fuller">
                                    <img src="{{asset('assets/img/avatars/5.png')}}" alt="Avatar"
                                        class="rounded-circle">
                                </li>
                                <li>{{$admin->name}}</li>
                            </ul>
                        </td>
                        <td>
                            <span>{{$admin->email}}</span>
                        </td>
                        <td><button onclick="adminStatusChange({{$admin->id}})"
                                id='changeStatus-{{$admin->id}}'>{!!$admin->admin->status==1 ? '<span
                                    class="badge badge-status bg-label-success me-1">Active</span>' :
                                '<span class="badge badge-status bg-label-dark me-1">Inactive</span>'!!}</button></td>
                        <td>
                            <div class="dropdown flex">

                                <a class="dropdown-item edit-btn" href="javascript:void(0);"
                                    onclick="getAdmin({{$admin->id}})"><i class="bx bx-edit-alt me-1"></i>
                                </a>
                                <a class="dropdown-item delete-btn" href="javascript:void(0);"
                                    onclick="deleteAdmin({{$admin->id}})"><i class="bx bx-trash me-1"></i>
                                </a>

                            </div>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addAdminForm">
                    <div class="modal-body">
                        <input type="hidden" id="adminId" name="id" value="">
                        <!-- Name Field -->
                        <div class="row">
                            <div class="col mb-3">
                                <label for="adminName" class="form-label">Name</label>
                                <input type="text" id="adminName" class="form-control" placeholder="Enter Name">
                                <small class="text-danger d-none" id="nameError">Name is required.</small>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="row g-3">
                            <div class="col mb-3">
                                <label for="adminEmail" class="form-label">Email</label>
                                <input type="email" id="adminEmail" class="form-control" placeholder="xxxx@xxx.xx">
                                <small class="text-danger d-none" id="emailError">Please enter a valid email.</small>
                            </div>
                        </div>

                        <!-- Password and Confirm Password -->
                        <div class="row">
                            <div class="col mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" placeholder="********">
                                <small class="text-danger d-none" id="passwordError">Password is required.</small>
                            </div>
                            <div class="col mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" id="confirmPassword" class="form-control" placeholder="********">
                                <small class="text-danger d-none" id="confirmPasswordError">Passwords do not
                                    match.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary !m-2"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary addAdminButton !m-2">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- / Content -->


<div class="content-backdrop fade"></div>


<!--/ Layout Demo -->
<script>
    // add admin form 
    document.getElementById('addAdminForm').addEventListener('submit', async function (e) {
    e.preventDefault(); // Prevent form submission
    
    // Get form values
    const id = document.getElementById('adminId').value.trim();
    const name = document.getElementById('adminName').value.trim();
    const email = document.getElementById('adminEmail').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();
    
    // Validation flags
    let isValid = true;
    
    // Name validation
    if (!name) {
        document.getElementById('nameError').classList.remove('d-none');
        isValid = false;
    } else {
        document.getElementById('nameError').classList.add('d-none');
    }
    
    // Email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailPattern.test(email)) {
        document.getElementById('emailError').classList.remove('d-none');
        isValid = false;
    } else {
        document.getElementById('emailError').classList.add('d-none');
    }
    
    // Password validation
    if (!password && !id) {
        document.getElementById('passwordError').classList.remove('d-none');
        isValid = false;
    } else {
        document.getElementById('passwordError').classList.add('d-none');
    }
    
    // Confirm password validation
    if (password !== confirmPassword && !id) {
        document.getElementById('confirmPasswordError').classList.remove('d-none');
        isValid = false;
    } else {
        document.getElementById('confirmPasswordError').classList.add('d-none');
    }
    
    // If all validations pass
    if (isValid) {
        // Add loader to button
        const submitButton = document.querySelector('.addAdminButton');
        const originalButtonText = submitButton.innerHTML;
        submitButton.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;
        submitButton.disabled = true;
    
        if (id === '') {
            try {
                // Perform AJAX call using fetch
                const response = await fetch('/admin/admin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // For Laravel CSRF protection
                    },
                    body: JSON.stringify({ name, email, password }),
                });
    
                // Parse JSON response
                const result = await response.json();
    
                if (response.status == 201) {
                    // alert('Admin added successfully!');
    
                    // Reset form
                    this.reset();
    
                    // update admin list
                    const adminList = document.getElementById('adminsList');
                    console.log(result);
                    let adminListData = '';
                    $.each(result.admins, function (index, admin) {
    
                        adminListData += `
                        <tr>
                            <td><span>${index + 1}</span></td>
                            <td>
                                <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-sm mr-3" title="Lilian Fuller">
                                        <img src="/assets/img/avatars/5.png" alt="Avatar"
                                            class="rounded-circle">
                                    </li>
                                    <li>` + admin.name + `</li>
                                </ul>
                            </td>
                            <td>
                                <span>` + admin.email + `</span>
                            </td>
                            <td> <button onclick="adminStatusChange(${admin.id})"
                                id='changeStatus-${admin.id}'>${admin.admin.status == 1
                                ? '<span class="badge bg-label-success me-1">Active</span>'
                                : '<span class="badge bg-label-dark me-1">Inactive</span>'} </button></td>
                            <td>
                                <div class="dropdown flex">
                                     <a class="dropdown-item edit-btn" href="javascript:void(0);"
                                    onclick="getAdmin(${admin.id})"><i class="bx bx-edit-alt me-1"></i>
                                </a>
                                <a class="dropdown-item delete-btn" href="javascript:void(0);"
                                    onclick="deleteAdmin(${admin.id})"><i class="bx bx-trash me-1"></i>
                                </a>
                                </div>
                            </td>
                        </tr>
                        `;
                    });
    
                    adminList.innerHTML = adminListData;
                    // Close modal (Bootstrap 5 method)
                    const modalElement = document.getElementById('basicModal');
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();
                } else {
                    // Handle validation or server-side errors
                    console.log(result.message || 'An error occurred while adding the admin.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again later.');
            } finally {
                // Reset button state
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
            }
        } else {
            try {
                submitButton.disabled = true;
                submitButton.innerHTML = 'Processing...';
    
                // Perform AJAX call for update admin
                const response = await fetch('/admin/admin/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ name, email, password }),
                });
    
                const result = await response.json();
    
                if (response.status == 200) {
    
                    this.reset();
    
                    const adminList = document.getElementById('adminsList');
                    console.log(result);
                    let adminListData = '';
                    $.each(result.admins, function (index, admin) {
    
                        adminListData += `
                        <tr>
                            <td><span>${index + 1}</span></td>
                            <td>
                                <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-sm mr-3" title="Lilian Fuller">
                                        <img src="/assets/img/avatars/5.png" alt="Avatar"
                                            class="rounded-circle">
                                    </li>
                                    <li>` + admin.name + `</li>
                                </ul>
                            </td>
                            <td>
                                <span>` + admin.email + `</span>
                            </td>
                            <td> <button onclick="adminStatusChange(${admin.id})"
                                id='changeStatus-${admin.id}'>${admin.admin.status == 1
                                ? '<span class="badge bg-label-success me-1">Active</span>'
                                : '<span class="badge bg-label-dark me-1">Inactive</span>'} </button></td>
                            <td>
                                <div class="dropdown flex">
                                     <a class="dropdown-item edit-btn" href="javascript:void(0);"
                                    onclick="getAdmin(${admin.id})"><i class="bx bx-edit-alt me-1"></i>
                                </a>
                                <a class="dropdown-item delete-btn" href="javascript:void(0);"
                                    onclick="deleteAdmin(${admin.id})"><i class="bx bx-trash me-1"></i>
                                </a>
                                </div>
                            </td>
                        </tr>
                        `;
                    });
    
                    adminList.innerHTML = adminListData;
                    // Close modal (Bootstrap 5 method)
                    const modalElement = document.getElementById('basicModal');
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();
                } else {
                    // Handle validation or server-side errors
                    console.log(result.message || 'An error occurred while adding the admin.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again later.');
            } finally {
                // Reset button state
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
            }
        }
    }
    });
</script>
<script>
    async function adminStatusChange(id) {
        try {
            // Perform AJAX call using fetch
            const res = await fetch('/admin/admin/' + id, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            });

            // Parse the response as JSON
            const response = await res.json();

            console.log(response);

            // Check the status code and handle the response
            if (res.status === 200) {
                document.getElementById('changeStatus-' + id).innerHTML =
                    response.admin.status === 1
                        ? '<span class="badge bg-label-success me-1">Active</span>'
                        : '<span class="badge bg-label-dark me-1">Inactive</span>';
            } else {
                console.error('An error occurred while updating the admin status.', response);
                console.log('Failed to update admin status. Please try again.');
            }
        } catch (error) {
            // Handle fetch/network errors
            console.error('Error:', error);
            console.log('An unexpected error occurred. Please try again later.');
        }
    }

    function getAdmin(id) {
        var myModal = new bootstrap.Modal(document.getElementById('basicModal'), {});
        myModal.show();

        // Perform AJAX call to get admin data by ID
        fetch('/admin/admin/' + id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateForm(data.admin);
            } else {
                console.error('Failed to fetch admin data:', data.error);
            }
        })
        .catch(error => {
            console.error('Error fetching admin data:', error);
        });
    }

    // Function to populate form fields with admin data
    function populateForm(admin) {
        document.getElementById('adminName').value = admin.name;
        document.getElementById('adminEmail').value = admin.email;
        document.getElementById('adminId').value = admin.id;
    }

    async function editAdmin(id) {
        try {
            // Perform AJAX call using fetch
            const res = await fetch('/admin/admin/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            });
        }catch (error) {
            console.log(error)
        }
    }

    async function deleteAdmin(id){
        try {
            // Perform AJAX call using fetch
            const res = await fetch('/admin/admin/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            });
            // Parse the response as JSON
            const response = await res.json();

            console.log(response);
            if(res.status === 200){
                $('#adminlist-'+id).remove();
            }else{
                console.log('Failed to delete')
            }
        }
        catch(error){
            console.log(error);
        }
    }
</script>


@endsection