<! DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Report Animal Sighting</title>
        <style>
            .container {
                width: 600px;
                margin: 50px auto;
                padding: 20px;
                border: 1px solid #eee;
                border-radius: 8px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
            }

            input,
            textarea,
            select {
                width: 100%;
                padding: 10px;
                box-sizing: border-box;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            .btn {
                padding: 12px 20px;
                background: #2196F3;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .btn:hover {
                background: #1976D2;
            }

            .btn-back {
                display: inline-block;
                padding: 10px 20px;
                background: #757575;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                margin-bottom: 20px;
            }

            .btn-back:hover {
                background: #616161;
            }

            .error {
                color: red;
                margin-bottom: 15px;
            }

            small {
                color: #666;
                font-size: 0.9em;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <!-- Back to Dashboard button -->
            <a href="{{ route('dashboard') }}" class="btn-back">⬅ Back to Dashboard</a>

            <!-- Main page heading for sighting report -->
            <h2>Report Animal Sighting</h2>

            <!-- Display validation errors if any -->
            @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
            @endif

            <!-- Sighting report form -->
            <form method="POST" action="{{ route('sighting.report') }}">
                @csrf

                <!-- Optional animal association field -->
                <div class="form-group">
                    <label>Associate with Identified Animal (Optional)</label>
                    <select name="animal_id" id="animal_id">
                        <option value="">-- Unidentified (create profile later) --</option>
                        <!-- In production, this would be populated via AJAX with existing animal records -->
                    </select>
                </div>

                <!-- Photo URLs input field -->
                <div class="form-group">
                    <label>Photo URLs (multiple URLs separated by commas)</label>
                    <input type="text" name="photo_urls" placeholder="https://example.jpg,https://example2.jpg" required>
                    <small>Note: In production, this could be replaced with file upload functionality</small>
                </div>

                <!-- Sighting location field -->
                <div class="form-group">
                    <label>Sighting Location</label>
                    <input type="text" name="location" placeholder="e.g., UPM Library Entrance" required>
                </div>

                <!-- Sighting date and time field -->
                <div class="form-group">
                    <label>Sighting Time</label>
                    <input type="datetime-local" name="sighting_time" required>
                </div>

                <!-- Animal status/condition field -->
                <div class="form-group">
                    <label>Animal Status</label>
                    <input type="text" name="status" placeholder="e.g., healthy/injured/starving" value="healthy">
                </div>

                <!-- Additional notes/observations field -->
                <div class="form-group">
                    <label>Notes</label>
                    <textarea name="notes" rows="3" placeholder="Additional description (behavior, characteristics, etc.)"></textarea>
                </div>

                <!-- Form submission button -->
                <button type="submit" class="btn">Submit Sighting Record</button>
            </form>
        </div>
        <script>
            // 加载最新动物列表并更新下拉菜单
            function loadAnimalOptions() {
                fetch("{{ route('api.animals') }}")
                    .then(response => response.json())
                    .then(animals => {
                        const selectEl = document.getElementById('animal_id');
                        // 保留默认选项，清空原有数据选项
                        const defaultOption = selectEl.querySelector('option[value=""]');
                        selectEl.innerHTML = '';
                        selectEl.appendChild(defaultOption);

                        // 渲染最新动物选项
                        animals.forEach(animal => {
                            const option = document.createElement('option');
                            option.value = animal.id;
                            option.textContent = `${animal.name} (ID: ${animal.id})`;
                            selectEl.appendChild(option);
                        });
                    })
                    .catch(err => console.error('加载动物数据失败：', err));
            }

            // 页面加载时执行
            document.addEventListener('DOMContentLoaded', loadAnimalOptions);

            // （可选）若有「新增动物」的功能，在新增成功后调用此方法刷新
            // 示例：onAnimalCreateSuccess() { loadAnimalOptions(); }
        </script>
    </body>

    </html>