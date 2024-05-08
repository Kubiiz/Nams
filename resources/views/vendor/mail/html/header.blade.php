@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<x-application-logo class="block w-40 fill-current" />
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
