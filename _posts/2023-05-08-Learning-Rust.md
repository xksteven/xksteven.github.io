---
layout: post
title:  "Learning Rust part 1"
date:   2023-05-08 12:00:00
categories: learning rust Rust
published: false
---

## Rust

### My plan to learn Rust

Read [the book](https://rust-book.cs.brown.edu/title-page.html) cover to cover, twice without doing any exercises. Then do [rustlings](https://github.com/rust-lang/rustlings).

### Notes as I read

Compile main.rs with rustc.  For everything other than really basic rust programs use cargo.

```rust
fn main() {
    println!("Hello, world!");
}
```

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

Honestly I'd recommend going through [learnxinyminutes/rust](https://learnxinyminutes.com/docs/rust/) instead of chapters 2, 3. Then resume the book for chapter 4.
