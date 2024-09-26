---
layout: post
title:  "Learning Rust part 1"
date:   2023-05-08 12:00:00
categories: learning rust Rust
published: false
---

## Rust

### My plan to learn Rust

I like this tutorial series [gentle intro to Rust](https://stevedonovan.github.io/rust-gentle-intro/readme.html)

### Install Rust

```bash
$ curl https://sh.rustup.rs -sSf | sh
$ rustup component add rust-docs
```

### Notes as I read

#### Basic rust program

`main.rs`
```rust
fn main() {
    println!("Hello, world!");
}
```

Compile main.rs with rustc. `rustc main.rs`

#### Cargo

For everything other than really basic rust programs use cargo.

Using cargo

```bash
cargo new package_name

# Creates package_name/
# package_name/src/main.rs
# package_name/Cargo.toml  <- put dependency info in there.
# The top-level project directory is just for README files, license information, configuration files, and anything else not related to your code.

cd package_name/

# For debugging and fast checking 
cargo check

# Build the executeable
# add --release for prod
cargo build  

# Run it manually
./target/debug/package_name

# Built it and Run it with cargo
cargo run
```

#### Command line args

Simple example

```rust
use std::env;

fn main() {
    let first = env::args().nth(1).expect("please supply an argument");
    let n: i32 = first.parse().expect("not an integer!");
    // do your magic
}
```

#### Reading from files

```rust
// file2.rs
use std::env;
use std::fs::File;
use std::io::Read;
use std::io;

// Verbose version
fn read_to_string(filename: &str) -> Result<String,io::Error> {
    let mut file = match File::open(&filename) {
        Ok(f) => f,
        Err(e) => return Err(e),
    };
    let mut text = String::new();
    match file.read_to_string(&mut text) {
        Ok(_) => Ok(text),
        Err(e) => Err(e),
    }
}

// Cleaner version
fn read_to_string(filename: &str) -> io::Result<String> {
    let mut file = File::open(&filename)?;
    let mut text = String::new();
    file.read_to_string(&mut text)?;
    Ok(text)
}

fn main() {
    let file = env::args().nth(1).expect("please supply a filename");

    let text = read_to_string(&file).expect("bad file man!");

    println!("file had {} bytes", text.len());
}

```

TODO Look up a better way to do this

#### traits

Here's a little example of defining a trait and implementing it for a particular type.


```rust
// trait1.rs

trait Show {
    fn show(&self) -> String;
}

impl Show for i32 {
    fn show(&self) -> String {
        format!("four-byte signed {}", self)
    }
}

impl Show for f64 {
    fn show(&self) -> String {
        format!("eight-byte float {}", self)
    }
}

fn main() {
    let answer = 42;
    let maybe_pi = 3.14;
    let s1 = answer.show();
    let s2 = maybe_pi.show();
    println!("show {}", s1);
    println!("show {}", s2);
}
// show four-byte signed 42
// show eight-byte float 3.14
```



### Practicing for leetcode

```
use std::collections::BinaryHeap;

```



```
use std::collections::HashMap;
```


