#!/usr/bin/env bash
set -euo pipefail

# 一键手动执行与验证脚本
# 用法：
#   ./test-scheduler.sh [--site-root /path/to/site] [--debug] [--verbose]

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PLUGIN_DIR="$SCRIPT_DIR"
SITE_ROOT_ARG=""
DEBUG="0"
VERBOSE="1"

while [[ $# -gt 0 ]]; do
  case "$1" in
    --site-root)
      SITE_ROOT_ARG="SITE_ROOT='${2:-}' "; shift 2;;
    --debug)
      DEBUG="1"; shift;;
    --verbose)
      VERBOSE="1"; shift;;
    --no-verbose)
      VERBOSE="0"; shift;;
    *)
      echo "Unknown option: $1"; exit 2;;
  esac
done

export BANK_DEBUG="$DEBUG"
export BANK_VERBOSE="$VERBOSE"

chmod +x "$PLUGIN_DIR/run-bank-scheduler.sh" || true
chmod +x "$PLUGIN_DIR/bank-scheduler.php" || true

LOG_DIR="$PLUGIN_DIR/logs"
mkdir -p "$LOG_DIR"
LOG_FILE="$LOG_DIR/bank_scheduler.test.$(date +%s).log"
export LOG_FILE

echo "[test] Running scheduler once..."
# 在同一 shell 会话中传递 SITE_ROOT（如有）并执行
if [[ -n "${SITE_ROOT_ARG}" ]]; then
  eval "${SITE_ROOT_ARG}" /bin/bash -lc "cd '$PLUGIN_DIR' && ./run-bank-scheduler.sh"
else
  /bin/bash -lc "cd '$PLUGIN_DIR' && ./run-bank-scheduler.sh"
fi

echo "[test] Tail log: $LOG_FILE"
tail -n 200 "$LOG_FILE" | cat

echo "[test] Done."


