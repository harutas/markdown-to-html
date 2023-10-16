import sys
import markdown


def main():
    args = sys.argv

    markdown_string = args[1]
    ishilite = args[2]

    config = {"codehilite": {"noclasses": ishilite == "True"}}

    html = markdown.markdown(
        markdown_string, extensions=["extra", "codehilite"], extension_configs=config
    )

    print(html)


if __name__ == "__main__":
    main()
