#!/usr/bin/env bash

# create symlink yo Voyager assets
rm -rf ./public/voyager
mkdir ./public/voyager
ln -s ../../vendor/tcg/voyager/publishable/assets ./public/voyager/
