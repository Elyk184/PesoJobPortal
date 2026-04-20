@extends('layouts.admin')

@section('title', 'Skills Gap Analysis | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Skills Gap Analysis', 'subtitle' => 'Identify skills gaps in the locality', 'icon' => 'bi-diagram-3'])

<div class="admin-dashboard">
    <style>
        .skill-item { background: white; padding: 1.5rem; border-radius: 10px; margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
        .skill-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .skill-name { font-weight: 700; color: #0d1f3c; }
        .skill-gap { font-size: 14px; color: #6b7280; }
        .progress-bar { width: 100%; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #d72638, #ef4444); border-radius: 4px; }
    </style>

    <div class="skill-item">
        <div class="skill-header">
            <div class="skill-name">Software Development</div>
            <div class="skill-gap">High Demand</div>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: 85%"></div>
        </div>
    </div>

    <div class="skill-item">
        <div class="skill-header">
            <div class="skill-name">Healthcare Professionals</div>
            <div class="skill-gap">High Demand</div>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: 92%"></div>
        </div>
    </div>

    <div class="skill-item">
        <div class="skill-header">
            <div class="skill-name">Digital Marketing</div>
            <div class="skill-gap">Medium Demand</div>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: 65%"></div>
        </div>
    </div>

    <div class="skill-item">
        <div class="skill-header">
            <div class="skill-name">Data Analysis</div>
            <div class="skill-gap">Medium Demand</div>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: 72%"></div>
        </div>
    </div>
</div>

@endsection
