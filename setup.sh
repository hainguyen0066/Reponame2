#!/usr/bin/env bash

# create symlink yo Voyager assets
rm -rf ./public/voyager
mkdir ./public/voyager
ln -s ../../vendor/tcg/voyager/publishable/assets ./public/voyager/


# create symlink for tcg/voyager
rm -rf vendor/tcg/voyager
ln -s ~/tools/voyager vendor/tcg


# create symlink for t2g/common
rm -rf vendor/t2g/common
ln -s ~/tools/common vendor/t2g
