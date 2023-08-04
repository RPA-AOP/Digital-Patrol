<div class="form-group row">
    <div class="col-sm-3 col-form-label">

        <label for="{{ $id }}">{{ $label }} @if($required)
                <span style="color: red;">*</span>
            @endif</label>
    </div>
    <div class="col-sm-9">
        <select id="{{$id}}" class="select2 form-control" @if($required)required="required"
                @endif @if($multiple)multiple="multiple" name="{{ $id }}[]" @else name="{{ $id }}" @endif>
            @if($initialValue!=null )
                @if($multiple)
                    @foreach($initialValue as $v)
                        <option value="{{$v[$primaryField]}}" selected>{{$v[$valueField]}}</option>
                    @endforeach
                @else
                    <option value="{{$initialValue[$primaryField]}}" selected>{{$initialValue[$valueField]}}</option>
                @endif
            @endif
        </select>
    </div>
</div>

@section('page-script')
    <!-- START SELECT2 {{strtoupper($label)}}-->
    <script nonce="{{ csp_nonce() }}">
        function formatState(state) {
            if (!state.newTag) {
                return state.text;
            }
            return $(
                '<span>' + state.text + '</span> <span class="badge badge-info">Add New</span> '
            );
        }
        var selector = $('#{{ $id }}');
        selector.wrap('<div class="position-relative"></div>');

        @if($chainedConfig!=null)
        @php $parent_selector = $chainedConfig['parent_selector'] @endphp
        let selectedParent_{{$id}} = $('#{{$parent_selector}}').val();
        selector.select2(
            {
                placeholder: "{{ $placeholder}}"
            }
        );
        $('#{{$parent_selector}}').change(function () {
            if ($(this).val()) {
                $.ajax({
                    url: '{{ route('select2.get') }}',
                    data: {
                        // search: params.term,
                        tableName: '{{$model}}',
                        primaryField: '{{$primaryField}}',
                        searchField: '{{$searchField}}',
                        valueField: '{{$valueField}}',
                        type: 'public',
                        {{$chainedConfig['parent_field']}}: selectedParent_{{$id}},
                    }
                }).done(function (data) {
                    const initialOption = new Option("-PILIH--", "", false, false);
                    $('#{{$id}}').append(initialOption).trigger('change');
                    $.map(data, function (obj) {
                        const option = new Option(obj.{{$valueField}}, obj.{{$primaryField}}, false, false);
                        $('#{{$id}}').append(option).trigger('change');
                    })
                })
            }

        })
        @else
        selector.select2(
            {
                placeholder: "{{ $placeholder }}",
                tags: true,
                ajax: {
                    url: '{{ route('select2.get') }}',
                    data: function (params) {
                        return {
                            search: params.term,
                            tableName: '{{$model}}',
                            primaryField: '{{$primaryField}}',
                            searchField: '{{$searchField}}',
                            valueField: '{{$valueField}}',
                            type: 'public',
                            @if($chainedConfig!=null)
                                {{$chainedConfig['parent_field']}}: selectedParent,
                            @endif
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.{{$primaryField}}, text: obj.{{$valueField}}};
                            })
                        };
                    }
                },
                @if($creation)
                templateResult: formatState,
                createTag: function (params) {
                    const term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true // add additional parameters
                    }
                },
                @else
                createTag: function (params) {
                    return undefined
                },
                @endif
            });
        @endif

        @if($creation)
        selector.on('select2:select', function (e) {
                let tag = e.params.data;
                if (tag.newTag === true) {
                    $.post("{{ route('select2.add')}}",
                        {
                            _token: "{{ csrf_token() }}",
                            model: "{{$model}}",
                            {{$valueField}}: tag.text
                        },
                        function (data, status) {
                            $('option[value="' + tag.text + '"]', $('#{{ $id }}'))
                                .attr('value', data.{{$primaryField}});
                            $('#{{ $id }}').trigger("change");
                        });
                }
            }
        )
        @endif
    </script>
    <!-- END SELECT2 {{strtoupper($label)}}-->
@endsection
