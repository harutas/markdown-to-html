import sys
import markdown


def main():
    args = sys.argv

    markdown_string = args[1]

    config = {"codehilite": {"noclasses": True}}

    html = markdown.markdown(
        markdown_string, extensions=["extra", "codehilite"], extension_configs=config
    )

    print(html)


if __name__ == "__main__":
    main()
