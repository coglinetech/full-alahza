@extends('layouts.app')

@section('content')
    @include('sections.hero')
    @include('sections.packages', ['packages' => $packages])
    @include('sections.why-us')
    @include('sections.about')
    {{-- @include('sections.gallery', ['gallery' => $gallery]) --}}
    {{-- @include('sections.instagram') --}}
    {{-- @include('sections.testimonials', ['testimonials' => $testimonials]) --}}
    @include('sections.faq', ['faqs' => $faqs])
    @include('sections.cta')
@endsection
