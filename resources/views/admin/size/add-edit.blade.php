@extends('admin.layouts.app')

@php $edit = isset($size) && $size; @endphp

@section('content')
    <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
        <div class="flex flex-row justify-between">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">
                {{ $edit ? 'Edit Size' : 'Add Size' }}
            </h2>
            <a href="{{ route('admin.sizes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fa-solid fa-backward"></i> Back
            </a>
        </div>

        <form action="{{ $edit ? route('admin.sizes.update', $size) : route('admin.sizes.store') }}"
              method="POST"
              id="sizeForm">
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
                        value="{{ old('name', $edit ? $size->name : '') }}"
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
            $("#sizeForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 1
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a size name",
                        minlength: "Size name must be at least 1 character"
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
                                    window.location.href = "{{ route('admin.sizes.index') }}";
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
