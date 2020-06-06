
@if(auth()->check())
    <div class="dropdown" style="float: right;">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" style="margin-left: 18px;margin-top: -4px;padding: 0px;background-color: #f7f7f7;">

        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @can('update' , $reply)

                <button class="dropdown-item" @click="destroy()"><i class="fa fa-trash" style="color: red"></i> Delete Reply</button>
                <button class="dropdown-item" @click="editing = true"><i class="fa fa-pencil" style="color: blue"></i> Edit</button>

            @endcan

            @cannot('update' , $reply)
                <form action="">

                    <button type="submit" class="dropdown-item"><i class="fa fa-bug" style="color: red"></i> Report This</button>
                </form>

            @endcannot

        </div>
    </div>
@endif