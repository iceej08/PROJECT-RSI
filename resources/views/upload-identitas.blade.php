<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up UBSC - Unggah Foto</title>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#004a73] to-[#003d5e]">
    <div class="min-h-screen flex items-center justify-center p-4">
            <!-- Main Card -->
                <div class="w-2/3 bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl p-8 md:p-14">
                    @include('alert')
                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-bold text-[#003d5e] mb-8">
                        Foto identitas Warga UB
                    </h1>

                    <!-- Upload Form -->
                    <form action="{{ route('signup.upload-identitas.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- File Upload Area -->
                        <div class="mb-6">
                            <div class="border-4 border-dashed border-gray-300 rounded-2xl bg-white p-12 text-center cursor-pointer hover:border-[#004a73] transition-all duration-300" 
                                 id="dropZone"
                                 onclick="document.getElementById('foto_identitas').click()">
                                
                                <!-- Upload Icon -->
                                <div class="flex flex-col items-center" id="uploadPrompt">
                                    <svg class="w-20 h-20 text-blue-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    
                                    <p class="text-gray-700 font-semibold text-lg mb-2">
                                        Drag and drop
                                    </p>
                                    <p class="text-gray-600 mb-2">
                                        files to upload
                                    </p>
                                    <p class="text-gray-500 text-sm mb-4">OR</p>
                                    
                                    <!-- Browse Button -->
                                    <button type="button" class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-8 py-3 rounded-full transition duration-300">
                                        Browse
                                    </button>
                                </div>

                                <!-- Preview Area (Hidden by default) -->
                                <div id="preview" class="hidden">
                                    <img id="previewImage" class="max-w-full max-h-64 mx-auto rounded-lg shadow-md mb-4" alt="Preview">
                                    <p id="fileName" class="text-sm text-gray-600 font-semibold mb-2"></p>
                                    <button type="button" onclick="removeFile()" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                                        ✕ Remove file
                                    </button>
                                </div>

                                <!-- Hidden File Input -->
                                <input 
                                    type="file" 
                                    name="foto_identitas" 
                                    id="foto_identitas"
                                    accept="image/jpeg,image/png,image/jpg"
                                    class="hidden"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            class="w-full mt-2 bg-orange-400 hover:bg-orange-500 text-white font-bold py-4 px-6 rounded-full transition duration-300 uppercase tracking-wide shadow-lg hover:shadow-xl text-lg">
                            Submit data
                        </button>

                        <!-- Info Text -->
                        <p class="text-center text-gray-600 text-sm mt-4">
                            Upload foto KTM, KTD atau KTP dengan jelas. Max 2MB (JPG, PNG, JPEG)
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('foto_identitas');
        const preview = document.getElementById('preview');
        const previewImage = document.getElementById('previewImage');
        const fileName = document.getElementById('fileName');
        const uploadPrompt = document.getElementById('uploadPrompt');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop zone when dragging over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('drag-active');
        }

        function unhighlight(e) {
            dropZone.classList.remove('drag-active');
        }

        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                fileInput.files = files;
                handleFile(files[0]);
            }
        }

        // File input change handler
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleFile(file);
            }
        });

        // Handle file preview
        function handleFile(file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please upload an image file');
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                return;
            }

            // Show preview
            uploadPrompt.classList.add('hidden');
            preview.classList.remove('hidden');
            fileName.textContent = file.name;

            // Read and display image
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        // Remove file function
        function removeFile() {
            fileInput.value = '';
            preview.classList.add('hidden');
            uploadPrompt.classList.remove('hidden');
        }
    </script>
</body>
</html>