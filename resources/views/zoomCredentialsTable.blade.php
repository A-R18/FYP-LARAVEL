{{-- This sub view shows the pending appointments to the admin which he can verify --}}
@extends('adminAction')

@section('content')

@php
    // dd($zoomCredentials)
@endphp

@if (isset($zoomCredentials) && $zoomCredentials->isNotEmpty())
        <table style="width: 55%">
            <thead>
                <tr>
                    
                    <th>Meeting ID</th>
                    <th>Meeting Passcode</th>
                    <th>Last Updated</th>

                    <th colspan="2">Action (U/D)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zoomCredentials as $zoom)
                    <tr>
                        
                        <td>{{ $zoom->meetingID }}</td>
                        <td>{{ $zoom->meetingPasscode }}</td>
                        <td>{{ $zoom->updated_at }}</td>

                        <td>    

                            <button><a href="{{route('showUpdateZoomForm', $zoom->id)}}" class="btt">Edit</a></button>


                        </td>
                        <td><button class="lobt"><a href="{{route('deleteZoomRecord', $zoom->id)}}" class=" btt">Delete</a></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No available credentials .</p>
    @endif

@endsection
