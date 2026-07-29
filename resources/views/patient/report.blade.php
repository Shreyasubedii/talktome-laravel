@extends('layouts.main')

@section('title','Therapist Report')

@section('content')


<div style="padding:40px;font-family:DejaVu Sans,sans-serif;">

<h1 style="text-align:center;">
    TalkToMe Mental Wellness Report
</h1>

<p style="text-align:center;color:#666;">
    {{ $periodText }}
</p>

<hr>

<table style="width:100%;margin-bottom:25px;">

<tr>

<td style="
border:1px solid #000;
padding:8px;
" >

<strong>Patient:</strong>

{{ $patient->pname }}

</td>

<td style="
border:1px solid #000;
padding:8px;
" align="right">

<strong>Date:</strong>

{{ now()->format('d M Y') }}

</td>

</tr>

</table>

@if($period == 'W')

<h2 style="margin-top:30px;">
    Weekly Reflection Summary
</h2>

<p style="color:#666;">
    {{ $reportRows[0]['date'] ?? '' }}
    -
    {{ end($reportRows)['date'] ?? '' }}
</p>

<table style="
width:100%;
border-collapse:collapse;
margin-top:20px;
font-size:13px;
">
    <thead>
        <tr>
            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Date</th>
            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Day</th>
            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Primary Emotions</th>
            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Possible Triggers</th>
            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Notes</th>
        </tr>
    </thead>

    <tbody>

    @foreach($reportRows as $row)

        <tr>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['date'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['day'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['primary_emotions'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['possible_triggers'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['notes'] }}</td>

        </tr>

    @endforeach

    </tbody>

</table>

@elseif($period == 'M')

<h2 style="margin-top:30px;">
    Monthly Reflection Summary
</h2>

<table style="width:100%;border-collapse:collapse;margin-top:20px;">

    <thead>

        <tr>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Week</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Average Mood</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Dominant Emotions</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Main Trigger</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Reflection Completion</th>

        </tr>

    </thead>

    <tbody>

    @foreach($reportRows as $row)

        <tr>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['week'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['average_mood'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['dominant_emotions'] }}</td>
            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['trigger'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['completion'] }}</td>

        </tr>

    @endforeach

    </tbody>

</table>

@elseif($period == '6M')

<h2 style="margin-top:30px;">
    Six Month Reflection Summary
</h2>

<table style="width:100%;border-collapse:collapse;margin-top:20px;">

    <thead>

        <tr>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Month</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Average Mood</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Dominant Emotions</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Main Trigger</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Reflection Completion</th>

        </tr>

    </thead>

    <tbody>

    @foreach($reportRows as $row)

        <tr>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['month'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['average_mood'] }}</td>

<td style="
border:1px solid #000;
padding:8px;
">{{ $row['dominant_emotions'] }}</td>
            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['trigger'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['completion'] }}</td>

        </tr>

    @endforeach

    </tbody>

</table>

@elseif($period == 'Y')

<h2 style="margin-top:30px;">
    Yearly Reflection Summary
</h2>

<table style="width:100%;border-collapse:collapse;margin-top:20px;">

    <thead>

        <tr>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Year</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Average Mood</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Dominant Emotions</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Main Trigger</th>

            <th style="
border:1px solid #000;
padding:8px;
background:#efefef;
">Reflection Completion</th>

        </tr>

    </thead>

    <tbody>

    @foreach($reportRows as $row)

        <tr>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['year'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['average_mood'] }}</td>

<td style="
border:1px solid #000;
padding:8px;
">{{ $row['dominant_emotions'] }}</td>
            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['trigger'] }}</td>

            <td style="
border:1px solid #000;
padding:8px;
">{{ $row['completion'] }}</td>

        </tr>

    @endforeach

    </tbody>

</table>

@endif

</div>

<hr style="margin-top:40px;">

<p style="
text-align:center;
font-size:12px;
color:#666;
">

This report was automatically generated by the TalkToMe Mental Wellness System.
It is not a diagnosis and is intended for personal reflection and discussion with a healthcare professional.

</p>

@endsection