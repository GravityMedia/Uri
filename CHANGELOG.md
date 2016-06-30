# Changelog

All Notable changes to `gravitymedia/uri` will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## NEXT - YYYY-MM-DD

### Added
- Nothing

### Changed 
- Nothing

### Deprecated
- Nothing

### Removed
- Nothing

### Fixed
- Nothing

### Security
- Nothing

## v0.2.0 - 2016-06-30

### Added
- A `SchemeRegistry` to support additional schemes
- The `AbstractQuery` class to manipulate the query string

### Changed
- The `Uri` object does now implement the PSR-7 `UriInterface`

### Removed
- Components, because they are not necessary any more

## v0.1.1 - 2015-03-10

### Changed 
- The default scheme is NULL instead of `file`

### Added
- Possibility to define the default port

### Fixed
- The method `Userinfo::toString()` does not crash when the user was not specified

## v0.1.0 - 2015-03-08

### Added
- Initial implementation of an `Uri` object to represent an URI
- Components to handle the `Authority`, `UserInfo` and `Query` parts of the URI
