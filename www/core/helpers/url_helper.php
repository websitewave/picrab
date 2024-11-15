<?php
// core/helpers/url_helper.php

function base_url($path = '')
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}