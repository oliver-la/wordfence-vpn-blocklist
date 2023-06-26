<?php

$sql = <<<'SQL'
    INSERT INTO `wp_wfblocks7` (
        `type`,
        `IP`,
        `blockedTime`,
        `reason`,
        `lastAttempt`,
        `blockedHits`,
        `expiration`,
        `parameters`
    ) VALUES (
        4,
        inet6_aton('::ffff:192.0.2.2'),
        1687776657,
        'VPN',
        0,
        0,
        0,
        '%1$s'
    );
SQL;
$sql = trim(str_replace("\n", "", $sql));

function cidrToRange($cidr) {
    $range = array();
    $cidr = explode('/', $cidr);
    $range[0] = long2ip((ip2long($cidr[0])) & ((-1 << (32 - (int)$cidr[1]))));
    $range[1] = long2ip((ip2long($range[0])) + pow(2, (32 - (int)$cidr[1])) - 1);
    return $range;
}

$list = file_get_contents(__DIR__ . '/ipv4.txt');
$list = explode("\n", $list);

foreach ($list as $key=>&$value) {
    if (empty($value)) {
        unset($list[$key]);
        continue;
    }

    $range = cidrToRange($value);

    $range_string = "{$range[0]}-{$range[1]}";

    $wf_parameters = json_encode([
        'ipRange' => $range_string,
        'hostname' => '',
        'userAgent' => '',
        'referrer' => ''
    ]);

    $value = sprintf($sql, $wf_parameters);
}

file_put_contents('output.sql', implode("\n", $list));
