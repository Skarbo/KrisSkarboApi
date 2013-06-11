<?php
/*
 * Copyright 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

global $apiConfig;
$apiConfig = array ( 'use_objects' => true, 'application_name' => '', 'oauth2_client_id' => '',
        'oauth2_client_secret' => '', 'oauth2_redirect_uri' => '', 'developer_key' => '',
        'site_name' => 'www.example.org', 'authClass' => 'Google_OAuth2', 'ioClass' => 'Google_CurlIO',
        'cacheClass' => 'Google_FileCache', 'basePath' => 'https://www.googleapis.com',
        'ioFileCache_directory' => ( function_exists( 'sys_get_temp_dir' ) ? sys_get_temp_dir() . '/Google_Client' : '/tmp/Google_Client' ),
        'services' => array ( 'analytics' => array ( 'scope' => 'https://www.googleapis.com/auth/analytics.readonly' ),
                'calendar' => array (
                        'scope' => array ( "https://www.googleapis.com/auth/calendar",
                                "https://www.googleapis.com/auth/calendar.readonly" ) ),
                'books' => array ( 'scope' => 'https://www.googleapis.com/auth/books' ),
                'latitude' => array (
                        'scope' => array ( 'https://www.googleapis.com/auth/latitude.all.best',
                                'https://www.googleapis.com/auth/latitude.all.city' ) ),
                'moderator' => array ( 'scope' => 'https://www.googleapis.com/auth/moderator' ),
                'oauth2' => array (
                        'scope' => array ( 'https://www.googleapis.com/auth/userinfo.profile',
                                'https://www.googleapis.com/auth/userinfo.email' ) ),
                'plus' => array ( 'scope' => 'https://www.googleapis.com/auth/plus.me' ),
                'siteVerification' => array ( 'scope' => 'https://www.googleapis.com/auth/siteverification' ),
                'tasks' => array ( 'scope' => 'https://www.googleapis.com/auth/tasks' ),
                'urlshortener' => array ( 'scope' => 'https://www.googleapis.com/auth/urlshortener' ) ) );

