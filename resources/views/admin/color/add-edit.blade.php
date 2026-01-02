@extends('admin.layouts.app')

@php $edit = isset($color) && $color; @endphp

@section('content')
    <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
        <div class="flex flex-row justify-between">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">
                {{ $edit ? 'Edit Color' : 'Add Color' }}
            </h2>
            <a href="{{ route('admin.colors.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fa-solid fa-backward"></i> Back
            </a>
        </div>

        <form action="{{ $edit ? route('admin.colors.update', $color) : route('admin.colors.store') }}"
              method="POST"
              id="colorForm">
            @csrf
            @if($edit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="name">Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $edit ? $color->name : '') }}"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                    >
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-600 dark:hover:bg-gray-700 dark:bg-gray-900 focus:outline-none">
                    Save
                </button>
            </div>
        </form>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $("#colorForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a color name",
                        minlength: "Color name must be at least 2 characters"
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $(form).attr('action'),
                        type: $(form).attr('method'),
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.success === true)
                            {
                                Swal.fire({
                                    title: "Success",
                                    text: response.message,
                                    icon: "success"
                                }).
                                then(() => {
                                    window.location.href = "{{ route('admin.colors.index') }}";
                                });

                            }

                        },
                        error: function(xhr) {
                            console.log(xhr.responseText)
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
