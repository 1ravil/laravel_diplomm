<tr>
    <td><input type="checkbox" class="adminPanelCheckbox" name="users_ids[]" value="{{ $user->id }}"></td>
    <td style="padding-left: 40px;">{{$user->id}}</td>
    <td style="padding-left: 20px;">{{$user->name}}</td>
    <td style="padding-left: 20px;">{{$user->created_at}}</td>
    <td style="padding-left: 20px;">{{$user->role}}</td>
    <td style="padding-left: 20px;">{{$user->email}}</td>
    <td style="padding-left: 20px;">{{ substr($user->password, 0, 5) }}...</td>
    <td>
        <a href="{{ route('adminPanelEditUser', ['id' => $user->id]) }}" class="adminPanelActionBtn">Редактировать</a>
    </td>

</tr>
