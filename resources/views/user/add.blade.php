
    <form action="{{url('/adddo')}}" method="post">
        @csrf
    用户名：<input type="text" name="name"><br>
    密码：<input type="number" name="age"><br>
    <input type="submit" value="添加">
</form>