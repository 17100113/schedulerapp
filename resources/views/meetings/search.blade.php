@extends('layouts.app')

@section('content')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if (count($users) === 0)
                    @elseif (count($users) >= 1)
                        <ul style="list-style: none;">
                        @foreach($users as $user)
                            @if($user->id != Auth::id())
                            <li>
                                <div style="padding: 15px;">
                                    <?= $user->name ?>
                                    <br>
                                        <?= $user->campusid ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#UserTimetable">Schedule Meeting</button>

                                        <div class="modal fade bs-example-modal-lg" id="UserTimetable" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <p>Select a Time slot</p>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table id="timetable" class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Monday <br> <?= date("d/m/Y",strtotime('monday')); ?></th>
                                                                <th>Tuesday <br> <?= date("d/m/Y",strtotime('tuesday')); ?></th>
                                                                <th>Wednesday <br> <?= date("d/m/Y",strtotime('wednesday')); ?></th>
                                                                <th>Thursday <br> <?= date("d/m/Y",strtotime('thursday')); ?></th>
                                                                <th>Friday <br> <?= date("d/m/Y",strtotime('friday')); ?></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($usercourses as $course)
                                                                    @if($course->userID == $user->id)
                                                                        <tr>
                                                                        <th scope="row"><?= $course->timing ?></th>
                                                                        @if(strpos($course->days, 'Mon') !== false)
                                                                            <td><?= $course->courseName ?>
                                                                                <br>
                                                                                Section: <?= $course->section ?></td>
                                                                        @else
                                                                            <td><button id="select" type="submit" class="btn btn-primary">Select</button></td>
                                                                        @endif
                                                                        @if(strpos($course->days, 'Tu') !== false)
                                                                            <td><?= $course->courseName ?>
                                                                                <br>
                                                                                Section: <?= $course->section ?></td>
                                                                        @else
                                                                            <td><button id="select" class="btn btn-primary">Select</button></td>
                                                                        @endif
                                                                        @if(strpos($course->days, 'Wed') !== false)
                                                                            <td><?= $course->courseName ?>
                                                                                <br>
                                                                                Section: <?= $course->section ?></td>
                                                                        @else
                                                                            <td><button id="select" class="btn btn-primary">Select</button></td>
                                                                        @endif
                                                                        @if(strpos($course->days, 'Th') !== false)
                                                                            <td><?= $course->courseName ?>
                                                                                <br>
                                                                                Section: <?= $course->section ?></td>
                                                                        @else
                                                                            <td><button id="select" class="btn btn-primary">Select</button></td>
                                                                        @endif
                                                                        @if(strpos($course->days, 'Fri') !== false)
                                                                            <td><?= $course->courseName ?>
                                                                                <br>
                                                                                Section: <?= $course->section ?></td>
                                                                        @else
                                                                            <td><button id="select" class="btn btn-primary">Select</button></td>
                                                                        @endif
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#select').on('click', function(){
            var cell = $(this).closest('td');
            var cellIndex = cell[0].cellIndex
            var row = cell.closest('tr');
            var rowIndex = row[0].rowIndex;
            var time = document.getElementById('timetable').rows[rowIndex].cells[0].innerText;
            var date = document.getElementById('timetable').rows[0].cells[cellIndex].innerText.split(' ')[1];
            var day = document.getElementById('timetable').rows[0].cells[cellIndex].innerText.split(' ')[0];
            $.ajax({
                method: 'GET',
                url: './schedule',
                data: {
                    Time: time,
                    Date: date,
                    Day: day
                },
                success: function(data) {
                    alert(data);
                },
                error: function(response){
                    alert('Error' + response);
                }
            });
        });
    </script>
@endsection
