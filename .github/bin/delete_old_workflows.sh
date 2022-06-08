#!/usr/bin/env bash

ORG=emmanuelballery
REPOSITORY=orange-billing-enabler
WORKFLOW_IDS=($(gh api "repos/$ORG/$REPOSITORY/actions/workflows" | jq '.workflows[] | .id'))

for WORKFLOW_ID in "${WORKFLOW_IDS[@]}"; do
  echo "Listing runs for the workflow ID $WORKFLOW_ID"
  RUN_IDS=($(gh api "repos/$ORG/$REPOSITORY/actions/workflows/$WORKFLOW_ID/runs" --paginate | jq '.workflow_runs[].id'))
  for RUN_ID in "${RUN_IDS[@]}"; do
    echo "Deleting Run ID $RUN_ID"
    gh api "repos/$ORG/$REPOSITORY/actions/runs/$RUN_ID" -X DELETE >/dev/null
  done
done
