<template>
    <div class="container mt-5 d-flex  ">

        <div class="w-50 mx-4">
            <form @submit.prevent="addTask" class="card card-body">
                <div class="form-group">
                    <input  class="form-control" placeholder="Task Title" required>
                </div>
                <div class="form-group">
                    <input  class="form-control" placeholder="Task Description" required>
                </div>
                <div class="form-group">
                    <input  class="form-control" placeholder="Assigned User" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add Task</button>
            </form>
            <div  class="error-message mt-4 text-danger">

            </div>
        </div>

        <div class="mx-4">
            <div class="d-flex flex-column">
                <label for="completedSelect" class="form-label">Filter</label>
                <select id="completedSelect" class="form-select form-select-sm">
                    <option selected value="all">all</option>
                    <option value="1">Completed</option>
                    <option value="0">No completed</option>
                </select>
            </div>
            <table class="table table-bordered mt-5">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <div  class="d-flex justify-content-center align-items-center">
                    <p class="text-center">Sin Tareas</p>
                </div>
                <tr  >
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        update
                    </button>
                    </td>

                </tr>

                </tbody>
            </table>
        </div>


        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form  class="card card-body">
                            <div class="form-group">
                                <input  class="form-control" placeholder="Task Title" required>
                            </div>
                            <div class="form-group">
                                <input  class="form-control" placeholder="Task Description" required>
                            </div>
                            <div class="form-group">
                                <input  class="form-control" placeholder="Assigned User" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Add Task</button>
                        </form>
                    </div>
                    <div  class="error-message text-center text-danger">

                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    </div>

</template>

<script>

</script>
