<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rows = Illuminate\Support\Facades\DB::select(
    "SELECT un.id, un.user_id, un.portal_notification_id, un.read_at, un.created_at, pn.title, pn.message, pn.created_by, pn.created_at AS portal_created_at
     FROM user_notifications un
     JOIN portal_notifications pn ON pn.id = un.portal_notification_id
     WHERE pn.title LIKE 'Job Recommendation:%'
     ORDER BY un.id DESC
     LIMIT 10"
);

foreach ($rows as $row) {
    echo $row->id . ' | user=' . $row->user_id . ' | portal=' . $row->portal_notification_id . ' | read=' . ($row->read_at ?? 'NULL') . ' | user_created=' . $row->created_at . PHP_EOL;
    echo '  title=' . $row->title . PHP_EOL;
    echo '  message=' . $row->message . PHP_EOL;
    echo '  created_by=' . $row->created_by . ' | portal_created=' . $row->portal_created_at . PHP_EOL;
}
