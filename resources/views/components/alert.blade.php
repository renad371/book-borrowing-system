@props(['type' => 'info', 'message'])

@php
    $colors = [
        'success' => '#4bb543',  
        'error' => '#ff3333',   
  
    ];

    $color = $colors[$type] ?? '#3399ff';  
@endphp

<div {{ $attributes->merge([
    'class' => "alert alert-$type",
    'style' => "background-color: {$color}1A; color: {$color}; border-left: 4px solid {$color}; padding: 10px 15px; margin-bottom: 15px; border-radius: 5px; font-size: 14px;" 
]) }}>
    {{ $message }}
</div>
