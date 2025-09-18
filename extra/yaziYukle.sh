#!/bin/bash

TOKEN=""
URL="https://example.com/kemik/yukle.php"

curl -X POST \
  -H "Authorization: Token $TOKEN" \
  -F "yazi=@$1" \
  $URL | jq