@extends('admin.website.layouts.master')

@section('title', 'Website Manage - JitoJeap Admin')

@section('website-content')
<div class="welcome-card">
    <h3><i class="fas fa-layer-group"></i> Welcome to Website Management</h3>
    <p>Manage your website's pages from this central dashboard. Use the sidebar to navigate between different sections.</p>
    
    <div class="quick-tips">
        <h4><i class="fas fa-lightbulb"></i> Quick Tips</h4>
        <ul>
            <li>Click on any page in the sidebar to manage that section</li>
            <li>Each page has its own settings and content management</li>
            <li>Changes are saved automatically</li>
        </ul>
    </div>
</div>
@endsection
