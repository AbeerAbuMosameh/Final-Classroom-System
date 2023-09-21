<div class="row">
    <div class="col-md-8">

        <div class="card card-custom border">
            <!--begin::Form-->
            <div class="card-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="title" name="title" value="{{ $classwork->title }}" class="form-control" placeholder="Title"/>
                    <x-form.error-feedback name="title"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Description (optional) </label>
                    <textarea
                        type="text" class="myeditor" name="description"
                        aria-describedby="emailHelp">{{ $classwork->description }} </textarea>
                    <x-form.error-feedback name="description"/>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card card-custom border">
            <div class="card-body">
                <div class="form-group" style="padding-bottom: 30px">
                    <label for="grade">Published At</label>
                    <input type="date" min="0" name="published_at" id="published_at"
                           value="{{ isset($classwork->published_at) ? date('Y-m-d', strtotime($classwork->published_at)) : '' }}"
                           class="form-control">
                    <x-form.error-feedback name="published_at"/>
                </div>

                <div class="form-group">
                    <label>Select Students</label>
                    <div></div>
                    <select class="form-control" name="students[]" multiple>
                        @foreach ($classroom->students as $student)
                            <option value="{{ $student->id }}"
                                    @if (isset($assignment) && in_array($student->id, $assignment ?? [], true)) selected @endif>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-form.error-feedback name="students[]"/>
                </div>

            @if($type == 'assignment')
                    <div class="form-group" style="padding-bottom: 30px">
                        <label for="grade">Grade</label>
                        <input type="number" min="0" name="options[grade]" id="grade"
                               value="{{ $classwork->options['grade'] ?? '' }}" class="form-control">
                        <x-form.error-feedback name="published_at"/>
                    </div>

                    <div class="form-group" style="padding-bottom: 30px">
                        <label for="due">Due Date</label>
                        <input type="date" name="options[due]" id="due" class="form-control"
                               value="{{ $classwork->options['due'] ?? '' }}">
                        <x-form.error-feedback name="options"/>
                    </div>

                @endif
                <div class="form-group">
                    <label>Topic</label>
                    <div></div>
                    <select class="form-control" name="topic_id" id="topic_id">
                        <option selected disabled>Select Topic</option>
                        @foreach ($classroom->topics as $topic)
                            <option value="{{ $topic->id }}"
                                    @if ($classwork->topic_id == $topic->id) selected @endif>{{ $topic->name }}</option>
                        @endforeach

                    </select>
                    <x-form.error-feedback name="topic_id"/>
                </div>
            </div>
        </div>
    </div>
</div>
