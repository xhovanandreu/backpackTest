@php
    $timetable = json_decode($entry->schedule, true);

    // dd($timetable);
@endphp

<button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#timetableModal{{ $entry->id }}">
    View Timetable
</button>

<!-- Modal -->
<div class="modal fade" id="timetableModal{{ $entry->id }}" tabindex="-1" aria-labelledby="timetableModalLabel{{ $entry->id }}" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timetableModalLabel{{ $entry->id }}">Weekly Timetable</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if ($timetable && isset($timetable['days']))
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Day</th>
                    <th>Sessions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($timetable['days'] as $day => $sessions)
                    <tr>
                      <td><strong>{{ $day }}</strong></td>
                      <td>
                        @if (count($sessions))
                          <ul class="mb-0 ps-3">
                            @foreach ($sessions as $session)
                              <li>{{ $session['start'] }} - {{ $session['end'] }}: {{ $session['subject'] }}</li>
                            @endforeach
                          </ul>
                        @else
                          <em>No classes</em>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        @else
            <p>No schedule available.</p>
        @endif
      </div>
    </div>
  </div>
</div>
