# Security Policy

## Supported Versions

Nexora CRM is built on Laravel 12 and PHP 8.3+. Security updates and bug fixes are maintained on the active `main` branch.

| Version | PHP Required | Laravel | Status    | Security Fixes |
| ------- | ------------ | ------- | --------- | -------------- |
| 1.0.x   | 8.3+         | 12.x    | Supported | Yes            |

---

## Reporting a Vulnerability

Please report security vulnerabilities **privately**. Do **not** open a public GitHub issue, pull request, or public discussion.

- **Repository Security Advisories:** Use GitHub's *Private Vulnerability Reporting* ("Security" -> "Advisories" -> "Report a vulnerability") on your Nexora repository.
- **Maintainer Contact:** Contact the repository owner directly via GitHub (`Isuru Rathnayaka`).

Please include:

- A clear description of the vulnerability
- Steps to reproduce (and a proof-of-concept, if available)
- Impact assessment
- Affected version or commit hash
- Any suggested remediation

---

## Security Process

1. **Acknowledgement:** Within 72 hours of receiving the report.
2. **Triage:** Reproduction, impact verification, and severity assessment.
3. **Fix & Release:** Patch developed on `main`, tested with Pest, and documented in the changelog/release notes.

Please allow reasonable time to release a fix before disclosing an issue publicly.
