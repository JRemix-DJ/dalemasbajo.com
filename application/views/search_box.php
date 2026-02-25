<div class="w-full">
    <form action="<? echo base_url('search/'); ?>" method="GET" class="mb-0">
        <div class="flex flex-col md:flex-row gap-3">

            <div class="relative flex-grow group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa fa-search text-slate-400 group-focus-within:text-primary transition-colors"></i>
                </div>
                <input type="text" name="sname" id="sname"
                       value="<? echo isset($_GET['sname']) ? $_GET['sname'] : ''; ?>"
                       class="block w-full p-3 pl-10 text-sm text-slate-900 border border-slate-200 rounded-lg bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                       placeholder="Search for remix, artist or title..." autocomplete="off">
            </div>

            <div class="w-full md:w-48">
                <div class="relative">
                    <select name="sgenero" id="sgenero" class="block w-full p-3 text-sm text-slate-700 border border-slate-200 rounded-lg bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none appearance-none cursor-pointer">
                        <option value="">Genre</option>
                        <? if(isset($generos)){ foreach($generos as $g) {
                            $selected = (isset($_GET['sgenero']) && $_GET['sgenero'] == $g->id) ? 'selected' : '';
                            ?>
                            <option value="<? echo $g->id; ?>" <? echo $selected; ?>><? echo $g->name; ?></option>
                        <? }} ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="fa fa-angle-down text-slate-400"></i>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-48">
                <div class="relative">
                    <select name="sremixers" id="sremixers" class="block w-full p-3 text-sm text-slate-700 border border-slate-200 rounded-lg bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none appearance-none cursor-pointer">
                        <option value="">Remixer</option>
                        <? if(isset($djs)){ foreach($djs as $dj) {
                            $selected = (isset($_GET['sremixers']) && $_GET['sremixers'] == $dj->id) ? 'selected' : '';
                            ?>
                            <option value="<? echo $dj->id; ?>" <? echo $selected; ?>><? echo $dj->username; ?></option>
                        <? }} ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="fa fa-angle-down text-slate-400"></i>
                    </div>
                </div>
            </div>

            <button type="submit" id="buscar-ahora" class="p-3 px-6 text-white bg-primary hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center transition-all shadow-md shadow-blue-500/20">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>
</div>