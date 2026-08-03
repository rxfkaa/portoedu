@extends('layouts.app')

@section('title','Projects')

@section('content')

<div class="container-fluid">

    <div class="page-header d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                💻 My Projects

            </h2>

            <p class="text-muted">

                Kelola semua project yang pernah kamu buat.

            </p>

        </div>

        <a
            href="{{ route('projects.create') }}"
            class="btn btn-primary rounded-4">

            <i class="bi bi-plus-circle me-2"></i>

            Tambah Project

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success rounded-4">

            {{ session('success') }}

        </div>

    @endif

    <div class="glass-card p-4">

        <div class="row">

            @forelse($projects as $project)

                <div class="col-lg-4 col-md-6 mb-4">

                    <div class="project-card h-100">

                        @if($project->image)

                            <img
                                src="{{ asset('storage/'.$project->image) }}"
                                class="project-image">

                        @else

                            <img
                                src="https://placehold.co/600x350?text=Project"
                                class="project-image">

                        @endif

                        <div class="p-3">

                            <h5 class="fw-bold">

                                {{ $project->title }}

                            </h5>

                            <span class="badge bg-primary">

                                {{ $project->category }}

                            </span>

                            <p class="text-muted mt-3">

                                {{ Str::limit($project->description,80) }}

                            </p>

                            <small>

                                {{ $project->technology }}

                            </small>

                            <hr>

                            <div class="d-flex gap-2">

                                <a
                                    href="{{ route('projects.show',$project) }}"
                                    class="btn btn-outline-primary btn-sm">

                                    Detail

                                </a>

                                <a
                                    href="{{ route('projects.edit',$project) }}"
                                    class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <form
                                    action="{{ route('projects.destroy',$project) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus project?')">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="text-center py-5">

                        <i class="bi bi-folder display-1 text-secondary"></i>

                        <h4 class="mt-3">

                            Belum ada project

                        </h4>

                        <p class="text-muted">

                            Silakan tambahkan project pertamamu.

                        </p>

                    </div>

                </div>

            @endforelse

        </div>

        <div class="mt-4">

            {{ $projects->links() }}

        </div>

    </div>

</div>

@endsection