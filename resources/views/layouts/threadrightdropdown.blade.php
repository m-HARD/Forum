@if(auth()->check())
    <div class="dropdown" style="float: right;">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" style="margin-left: 8px;padding: 0px;background-color: #f7f7f7;">

        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @can('update' , $thread)

                <form action="{{ $thread->path() }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" class="dropdown-item"><i class="fa fa-trash" style="color: red"></i> Delete Thread</button>
            </form>


            @endcan

            @cannot('update' , $thread)
            <form action="">

                <button type="submit" class="dropdown-item"><i class="fa fa-bug" style="color: red"></i> Report This</button>
            </form>

            @endcannot

        </div>
    </div>
@endif