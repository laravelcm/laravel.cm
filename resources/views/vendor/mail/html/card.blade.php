<table class="card" width="100%" cellpadding="0" cellspacing="0" role="presentation">
  <tr>
    <td class="card-content">
      <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
          <td class="card-image">
            {{ $image ?? '' }}
          </td>
          <td class="card-description">
            <a href="{{ $url }}" style="display: inline-block;">
              <span style="position: absolute; top: 0; left: 0; right: 0; bottom: 0" aria-hidden="true"></span>
              <p class="card-title">{{ $title }}</p>
            </a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

