@php
$container = 'container-xxl';
$containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Classes')

@section('headlinks')
<!-- DataTables CSS -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">

@endsection

@section('content')

<!-- Content -->
<div class="col-xxl-8 flex-grow-1 ">
    <div class="row g-6 mb-6">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Classes</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{count($classes)}}</h4>

                                {{-- <p class="text-success mb-0">(+29%)</p> --}}
                            </div>
                            <small class="mb-0">Total no. of classes</small>
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
                            <span class="text-heading">Total Students</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{array_sum(array_map(fn($class) => $class['students_count'],
                                    $classes->toArray()));
                                    }}</h4>
                                {{-- <p class="text-success mb-0">(+18%)</p> --}}
                            </div>
                            <small class="mb-0">students in classes</small>
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
                            <span class="text-heading">Total Teachers</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $classes->sum(fn($class) =>
                                    $class->subjects->sum('teachers_count')) }}</h4>
                                {{-- <p class="text-danger mb-0">(-14%)</p>--}}
                            </div>
                            <small class="mb-0">Teachers in classes</small>
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
            <h5 class="card-header flex-1">Classes</h5>
            <div class="btn-placer flex">

            </div>
            <button type="button" class="btn btn-primary p-2 m-auto !mr-2" data-bs-toggle="modal"
                data-bs-target="#classModal">
                <i class="fas fa-plus mr-2"></i> Add Class
            </button>
        </div>
        <div class="table-responsive text-nowrap !m-3 !w-[98%]">
            <table class="table" id="classTable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Students</th>
                        <th>Subjects(Teach.)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 " id="classesList">
                    @foreach ($classes as $index => $class)

                    <tr id="classlist-{{$class->id}}">
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
                                        <li><span>{{$class->name}}</span></li>
                                        <li><span class="text-xs">Section - {{$class->section}}</span></li>
                                    </ul>
                                </li>
                            </ul>
                        </td>

                        <td><span>{{$class->students_count>0 ? $class->students_count : "No Student assigned."}}</span>
                        </td>
                        <td>@if($class->subjects->count() > 0)
                            <ul>@foreach ($class->subjects as $item)
                                <li>{{$item->name}} ({{$item->teachers_count}})</li>
                                @endforeach
                            </ul>
                            @else
                            <span>No subjects assigned.</span>
                            @endif
                        </td>

                        <td>
                            <div class="dropdown flex">

                                <a class="dropdown-item edit-btn" href="javascript:void(0);"
                                    onclick="getTeacher({{$class->id}})"><i class="bx bx-edit-alt me-1"></i>
                                </a>
                                <a class="dropdown-item delete-btn" href="javascript:void(0);"
                                    onclick="deleteTeacher({{$class->id}})"><i class="bx bx-trash me-1"></i>
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
    <div class="modal fade" id="classModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addClassrForm">
                    <div class="modal-body">
                        <input type="hidden" id="classId" name="id" value="">
                        <!-- Name Field -->
                        <div class="row">
                            <div class="col mb-3">
                                <label for="className" class="form-label">Class Name</label>
                                <input type="text" id="className" class="form-control" placeholder="Enter Name">
                                <small class="text-danger d-none" id="classNameError">Class Name is required.</small>
                            </div>
                        </div>

                        <!-- section Field -->
                        <div class="row g-3">
                            <div class="col mb-3">
                                <label for="section" class="form-label">Section</label>
                                <input type="section" id="section" class="form-control" placeholder="A,B....">
                                <small class="text-danger d-none" id="sectionError">Please enter a section.</small>
                            </div>

                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary !m-2"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary addClassButton !m-2">Save changes</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- / Content -->


<div class="content-backdrop fade"></div>


<!--/ Layout Demo -->

@endsection

@section('page-script')

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- JSZip (for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

{{-- dataTable export btn js --}}
<script>
    new DataTable('#classTable',{
        dom: '<"top"lfB><"table-responsive !w-[100%]"t><"bottom"ip>',
    
        buttons: [ {
                extend: 'collection',
                text: 'Export',  // Button label
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],  // Dropdown items
                className: ' btn-secondary dropdown-toggle p-2 m-auto !mr-2 '  // Custom class for 
            }],
            initComplete: function () {
            // Move the export button to the flex container
            var exportBtn = $('.dt-button').detach(); // Detach export button
            exportBtn.html('<i class="bx bx-export mr-2"></i> Export'); 
            $('.btn-placer').append(exportBtn); // Append to the flex container
        }
    });
</script>

<script>
    //add teacher form 
    document.getElementById('addClassrForm').addEventListener('submit', async function (e) {
        e.preventDefault(); // Prevent form submission
    
        // Get form values
        const id = document.getElementById('classId').value.trim();
        const name = document.getElementById('className').value.trim();
        const section = document.getElementById('section').value.trim();
        
    
        // Validation flags
        let isValid = true;
    
        // Name validation
        if (!name) {
            document.getElementById('classNameError').classList.remove('d-none');
            isValid = false;
        } else {
            document.getElementById('classNameError').classList.add('d-none');
        }
    
       
    
        //section validation 
        if (!section) {
            document.getElementById('sectionError').classList.remove('d-none');
            isValid = false;
        } else {
            document.getElementById('sectionError').classList.add('d-none');
        }
    
    
        if (isValid) {
            const submitButton = document.querySelector('.addClassButton');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;
            submitButton.disabled = true;
    
            if (id === '') {
                try {
                    // Perform AJAX call using fetch
                    const response = await fetch('/admin/class', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // For Laravel CSRF protection
                        },
                        body: JSON.stringify({ name, section}),
                    });
    
                    // Parse JSON response
                    const result = await response.json();
    
                    if (response.status == 201) {
    
                        // Reset form
                        this.reset();
    
                        // update class list
                        const classList = document.getElementById('classList');
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