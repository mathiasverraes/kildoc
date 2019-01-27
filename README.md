# Kildoc

I always have to google which characters to use when doing date formats

```
<?php
echo $date->format("Y-m-d\TH:i:sO");
```

So what if I didn't have to?

```
<?php
$format = (new DateFormat)
        ->year()->dash()->month()->dash()->day()
        ->raw("\T")
        ->hours()->colon()->minutes()->colon()->seconds()
        ->diffToUTCInHours();

echo $format($date); // 2019-02-07T10:25:55+0100
);
```

Find more examples in the tests.
 
## Status 

This is very much proof of concept code, so if you want to use this, expect to contribute, or fork it or steal it.

