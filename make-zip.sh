#!/bin/bash
VERSION=$(grep  'Version:.*' uafrica-shipping.php | sed -E "s/.* ([.0-9])/\\1/")
ZIPNAME="disable-fse.zip"
echo "** creating zip: ${ZIPNAME}"
rm "${ZIPNAME}"
zip -r "${ZIPNAME}" . -x \
./.wordpress.org \
./node_modules\* \
./.git\* \
./vendor\* \
./package.json \
./package-lock.json \
./composer.json \
./composer.lock \
./.distignore* \
./.editorconfig* \
./.gitignore* \
./.idea\* \
./.phpcs.xml.dist \
./README.md \
./readme.md \
./make-zip.sh \
./docs\* \
./.wordpress-org\* \

#mv ${ZIPNAME} ~/Downloads/
