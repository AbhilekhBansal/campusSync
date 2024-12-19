@php
$container = 'container-xxl';
$containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Teachers')

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
                            <span class="text-heading">Total Teachers</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{count($teachs)}}</h4>

                                {{-- <p class="text-success mb-0">(+29%)</p> --}}
                            </div>
                            <small class="mb-0">Total Teachers</small>
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
                            <span class="text-heading">Total Subjects</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{$subjects->count()}}</h4>
                                {{-- <p class="text-success mb-0">(+18%)</p> --}}
                            </div>
                            <small class="mb-0">Last week analytics </small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-book bx-lg"></i>
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
                            <span class="text-heading">Active Teachers</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $teachs->filter(fn($teachs) => $teachs->teacher['status'] ===
                                    1)->count() }}</h4>
                                {{-- <p class="text-danger mb-0">(-14%)</p> --}}
                            </div>
                            <small class="mb-0">Total Teachers ({{count($teachs)}})</small>
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

            <h5 class="card-header flex-1">Student List</h5>
            <button type="button" class="btn btn-primary p-2 m-auto !mr-2" data-bs-toggle="modal"
                data-bs-target="#teacherModal">
                <i class="fas fa-plus mr-2"></i> Add Teach
            </button>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        {{-- <th>Email</th> --}}
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 " id="teachersList">
                    @foreach ($teachs as $index => $teach)

                    <tr id="teacherlist-{{$teach->id}}">
                        <td><span>{{$index+1}}</span></td>
                        <td>
                            <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    class="avatar avatar-sm mr-3" title="Lilian Fuller">
                                    <img src="{{asset('assets/img/avatars/5.png')}}" alt="Avatar"
                                        class="rounded-circle">
                                </li>
                                <li>
                                    <ul>
                                        <li><span>{{$teach->name}}</span></li>
                                        <li><span>{{$teach->email}}</span></li>
                                    </ul>
                                </li>
                            </ul>
                        </td>
                        {{-- <td>
                            <span>{{$teach->email}}</span>
                        </td> --}}
                        <td><span>{{$teach->teacher->subject->name}}</span></td>
                        <td><button onclick="teacherStatusChange({{$teach->id}})"
                                id='changeStatus-{{$teach->id}}'>{!!$teach->teacher->status==1 ? '<span
                                    class="badge badge-status bg-label-success me-1">Active</span>' :
                                '<span class="badge badge-status bg-label-dark me-1">Inactive</span>'!!}</button></td>
                        <td>
                            <div class="dropdown flex">

                                <a class="dropdown-item edit-btn" href="javascript:void(0);"
                                    onclick="getTeacher({{$teach->id}})"><i class="bx bx-edit-alt me-1"></i>
                                </a>
                                <a class="dropdown-item delete-btn" href="javascript:void(0);"
                                    onclick="deleteTeacher({{$teach->id}})"><i class="bx bx-trash me-1"></i>
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
    <div class="modal fade" id="teacherModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTeacherForm">
                    <div class="modal-body">
                        <input type="hidden" id="teacherId" name="id" value="">
                        <!-- Name Field -->
                        <div class="row">
                            <div class="col mb-3">
                                <label for="teacherName" class="form-label">Name</label>
                                <input type="text" id="teacherName" class="form-control" placeholder="Enter Name">
                                <small class="text-danger d-none" id="nameError">Name is required.</small>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="row g-3">
                            <div class="col mb-3">
                                <label for="teacherEmail" class="form-label">Email</label>
                                <input type="email" id="teacherEmail" class="form-control" placeholder="xxxx@xxx.xx">
                                <small class="text-danger d-none" id="emailError">Please enter a valid email.</small>
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col mb-3">
                                <label for="teacherSubject" class="form-label">Subject</label>
                                <select id="teacherSubject" class="form-select">
                                    <option>Default select</option>
                                    @foreach ($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->name}}</option>

                                    @endforeach
                                </select>
                                <small class="text-danger d-none" id="subjectError">Please select a subject.</small>
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
                        <button type="submit" class="btn btn-primary addTeacherButton !m-2">Save changes</button>
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
    //add teacher form 
    document.getElementById('addTeacherForm').addEventListener('submit', async function (e) {
        e.preventDefault(); // Prevent form submission
    
        // Get form values
        const id = document.getElementById('teacherId').value.trim();
        const name = document.getElementById('teacherName').value.trim();
        const email = document.getElementById('teacherEmail').value.trim();
        const subject = document.getElementById('teacherSubject').value.trim();
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
    
        //subject validation 
        if (!subject) {
            document.getElementById('subjectError').classList.remove('d-none');
            isValid = false;
        } else {
            document.getElementById('subjectError').classList.add('d-none');
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
    
        if (isValid) {
            const submitButton = document.querySelector('.addTeacherButton');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;
            submitButton.disabled = true;
    
            if (id === '') {
                try {
                    // Perform AJAX call using fetch
                    const response = await fetch('/admin/teacher', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // For Laravel CSRF protection
                        },
                        body: JSON.stringify({ name, email, password, subject }),
                    });
    
                    // Parse JSON response
                    const result = await response.json();
    
                    if (response.status == 201) {
                        // alert('Admin added successfully!');
    
                        // Reset form
                        this.reset();
    
                        // update teacher list
                        const teachersList = document.getElementById('teachersList');
                        console.log(result);
                        let teachersListData = '';
                        $.each(result.teachs, function (index, teach) {
    
                            teachersListData += `
                            <tr>
                                <td><span>${index + 1}</span></td>
                                <td>
                                    <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            class="avatar avatar-sm mr-3" title="Lilian Fuller">
                                            <img src="/assets/img/avatars/5.png" alt="Avatar"
                                                class="rounded-circle">
                                        </li>
                                        <li>
                                        <ul>
                                            <li><span>${teach.name}</span></li>
                                            <li><span>${teach.email}</span></li>
                                        </ul>
                                    </li>
                                    </ul>
                                </td>
                                <td>
                                    <span>${teach.teacher.subject.name}</span>
                                </td>
                                <td> <button onclick="teacherStatusChange(${teach.id})"
                                    id='changeStatus-${teach.id}'>${teach.teacher.status == 1
                                    ? '<span class="badge bg-label-success me-1">Active</span>'
                                    : '<span class="badge bg-label-dark me-1">Inactive</span>'} </button></td>
                                <td>
                                    <div class="dropdown flex">
                                         <a class="dropdown-item edit-btn" href="javascript:void(0);"
                                        onclick="getTeacher(${teach.id})"><i class="bx bx-edit-alt me-1"></i>
                                    </a>
                                    <a class="dropdown-item delete-btn" href="javascript:void(0);"
                                        onclick="deleteTeacher(${teach.id})"><i class="bx bx-trash me-1"></i>
                                    </a>
                                    </div>
                                </td>
                            </tr>
                            `;
                        });
    
                        teachersList.innerHTML = teachersListData;
                        // Close modal (Bootstrap 5 method)
                        const modalElement = document.getElementById('teacherModal');
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
                    const response = await fetch('/admin/teacher/' + id, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ name, email,subject, password }),
                    });
    
                    const result = await response.json();
    
                    if (response.status == 200) {
    
                        this.reset();
    
                        // update teacher list
                        const teachersList = document.getElementById('teachersList');
                        console.log(result);
                        let teachersListData = '';
                        $.each(result.teachers, function (index, teach) {
    
                            teachersListData += `
                            <tr>
                                <td><span>${index + 1}</span></td>
                                <td>
                                    <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            class="avatar avatar-sm mr-3" title="Lilian Fuller">
                                            <img src="/assets/img/avatars/5.png" alt="Avatar"
                                                class="rounded-circle">
                                        </li>
                                        <li>
                                        <ul>
                                            <li><span>${teach.name}</span></li>
                                            <li><span>${teach.email}</span></li>
                                        </ul>
                                    </li>
                                    </ul>
                                </td>
                                <td>
                                    <span>${teach.teacher.subject.name}</span>
                                </td>
                                <td> <button onclick="teacherStatusChange(${teach.id})"
                                    id='changeStatus-${teach.id}'>${teach.teacher.status == 1
                                    ? '<span class="badge bg-label-success me-1">Active</span>'
                                    : '<span class="badge bg-label-dark me-1">Inactive</span>'} </button></td>
                                <td>
                                    <div class="dropdown flex">
                                         <a class="dropdown-item edit-btn" href="javascript:void(0);"
                                        onclick="getTeacher(${teach.id})"><i class="bx bx-edit-alt me-1"></i>
                                    </a>
                                    <a class="dropdown-item delete-btn" href="javascript:void(0);"
                                        onclick="deleteTeacher(${teach.id})"><i class="bx bx-trash me-1"></i>
                                    </a>
                                    </div>
                                </td>
                            </tr>
                            `;
                        });
    
                        teachersList.innerHTML = teachersListData;
                        // Close modal (Bootstrap 5 method)
                        const modalElement = document.getElementById('teacherModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        // Handle validation or server-side errors
                        console.log(result.message || 'An error occurred while adding the teacher.');
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
    async function teacherStatusChange(id) {
        try {
            // Perform AJAX call using fetch
            const res = await fetch('/admin/teacher/' + id, {
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
                    response.teacher.status === 1
                        ? '<span class="badge bg-label-success me-1">Active</span>'
                        : '<span class="badge bg-label-dark me-1">Inactive</span>';
            } else {
                console.error('An error occurred while updating the teacher status.', response);
                console.log('Failed to update teacher status. Please try again.');
            }
        } catch (error) {
            // Handle fetch/network errors
            console.error('Error:', error);
            console.log('An unexpected error occurred. Please try again later.');
        }
    }
    
    
    function getTeacher(id) {
        var myModal = new bootstrap.Modal(document.getElementById('teacherModal'), {});
        myModal.show();
    
        // Perform AJAX call to get admin data by ID
        fetch('/admin/teacher/' + id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateForm(data.teacher);
            } else {
                console.error('Failed to fetch admin data:', data.error);
            }
        })
        .catch(error => {
            console.error('Error fetching admin data:', error);
        });
    }
    
    function populateForm(teacher) {
        document.getElementById('teacherName').value = teacher.name;
        document.getElementById('teacherEmail').value = teacher.email;
        document.getElementById('teacherId').value = teacher.id;
        // document.getElementById('teacherSubject').innerhtml = '<option value='+teacher.teacher.subject_id+' selected>'+teacher.teacher.subject.name+'</option>';

        const teacherSubject = document.getElementById('teacherSubject');
        const subjectOption = document.createElement('option');

        subjectOption.value = teacher.teacher.subject_id;
        subjectOption.textContent = teacher.teacher.subject.name;
        subjectOption.selected = true;

        // teacherSubject.appendChild(subjectOption);
        teacherSubject.insertBefore(subjectOption, teacherSubject.firstChild); // Insert at the top

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
    
    async function deleteTeacher(id){
        try {
            // Perform AJAX call using fetch
            const res = await fetch('/admin/teacher/' + id, {
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
                $('#teacherlist-'+id).remove();
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