<form>
    <select name="interval">
        <input type="hidden" name="data_export" value="{{$data_export}}" />
        <option value="today" selected> Today </option>
        <option value="this_week"> This Week </option>
        <option value="last_week"> Last Week </option>
        <option value="this_month"> This Month </option>
        <option value="last_month"> Last Month </option>
        <option value="all"> Everthing </option>
    </select>
    <button> Export </button>
</form>
<section style="display:none">
    <label for="batch_progress"> Export progress </label>
    <progress id="batch_progress" max=""> 
        Starting 
    </progress>
</section>
